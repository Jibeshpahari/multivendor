<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SettingKey;
use App\Http\Controllers\Controller;
use App\Models\Admin\TaskNote;
use App\Models\Admin\TaskNoteTopic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Throwable;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Notes';
        $nav = [];
        $userId = $request->user()->id;

        $topics = TaskNoteTopic::where('user_id', $userId)
            ->orderBy('name')
            ->get();

        $notes = TaskNote::with('taskNoteTopic')
            ->where('user_id', $userId)
            ->when($request->filled('topic'), fn($q) => $q->where('topic_id', $request->topic))
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('priority'), fn($q) => $q->where('priority', $request->priority))
            ->when($request->filled('q'), fn($q) => $q->where('title', 'like', '%' . $request->q . '%'))
            ->when($request->filled('from'), fn($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('created_at', '<=', $request->to))
            ->orderByDesc('created_at')
            ->paginate($request->integer('per_page', setting(SettingKey::AdminPaginationPerPage)))
            ->withQueryString();

        $grouped = $notes->getCollection()->groupBy(function ($note) {
            if ($note->created_at->isToday()) {
                return 'Today';
            }
            if ($note->created_at->isYesterday()) {
                return 'Yesterday';
            }
            return $note->created_at->format('F j, Y');
        });

        $counts = [
            'all' => TaskNote::where('user_id', $userId)->count(),
            'topics' => TaskNote::where('user_id', $userId)
                ->selectRaw('topic_id, count(*) as c')->groupBy('topic_id')->pluck('c', 'topic_id')->toArray(),
            'statuses' => TaskNote::where('user_id', $userId)
                ->selectRaw('status, count(*) as c')->groupBy('status')->pluck('c', 'status')->toArray(),
            'priorities' => TaskNote::where('user_id', $userId)
                ->selectRaw('priority, count(*) as c')->groupBy('priority')->pluck('c', 'priority')->toArray(),
        ];

        $filters = $request->only(['topic', 'status', 'priority', 'q', 'from', 'to']);
        return view('admin.tasknote.index', compact('title', 'nav', 'topics', 'notes', 'grouped', 'counts', 'filters'));
    }

    public function save(Request $request, $id = null)
    {
        $userId = auth('web')->id();
        $taskNote = $id
            ? TaskNote::where('user_id', $userId)->where('id', $id)->firstOrFail()
            : null;

        $isUpdate = (bool) $taskNote;

        $validated = $request->validate([
            'topic_id' => [
                'required',
                Rule::exists('task_note_topics', 'id')->where('user_id', $userId),
            ],
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('task_notes', 'title')->where('user_id', $userId)->ignore($taskNote?->id),
            ],
            'content'     => 'nullable|string',
            'status'      => 'sometimes|in:todo,progress,done',
            'priority'    => 'sometimes|in:low,medium,high,urgent',
            'reminder_at' => 'nullable|date|after:now',
        ]);

        $validated['status']   ??= 'todo';
        $validated['priority'] ??= 'medium';

        DB::beginTransaction();

        try {
            $taskNote = TaskNote::updateOrCreate(
                ['id' => $taskNote?->id],
                [
                    'user_id'     => $userId,
                    'topic_id'    => $validated['topic_id'],
                    'title'       => $validated['title'],
                    'content'     => $validated['content'] ?? null,
                    'status'      => $validated['status'],
                    'priority'    => $validated['priority'],
                    'reminder_at' => $validated['reminder_at'] ?? null,
                ]
            );
            DB::commit();

            $taskNote->is_overdue = $taskNote->reminder_at
                && $taskNote->status !== 'done'
                && Carbon::parse($taskNote->reminder_at)->isPast();

            $topics = TaskNoteTopic::where('user_id', $userId)->orderBy('name')->get();

            return response()->json([
                'success' => true,
                'message' => $isUpdate ? 'Note updated successfully.' : 'Note saved successfully.',
                'html'    => view('admin.tasknote.partials.note-card', [
                    'note'   => $taskNote,
                    'topics' => $topics,
                ])->render(),
            ], 201);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, no changes were saved.',
            ], 500);
        }
    }

    public function addTopic(Request $request)
    {
        $userId = auth('web')->id();
        $validated = $request->validate([
            'name' => ['required', 'string', Rule::unique('task_note_topics', 'name')->where('user_id', $userId)],
        ]);

        DB::beginTransaction();

        try {
            $taskNoteTopic = TaskNoteTopic::create([
                'user_id' => $userId,
                'name' => $validated['name'],
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Topic \"{$taskNoteTopic->name}\" Added",
            ], 201);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, no changes were saved.',
                'Error'   => $th->getMessage(),
            ], 500);
        }
    }

    // The Task is completed.
    public function done(Request $request)
    {
        $userId = auth('web')->id();
        $topics = TaskNoteTopic::where('user_id', $userId)->orderBy('name')->get();
        $validated = $request->validate([
            'id' => [
                'required',
                Rule::exists('task_notes', 'id')->where('user_id', $userId),
            ],
            'status' => ['required', 'in:todo,done'],
        ]);

        $taskNote = TaskNote::where('user_id', $userId)->where('id', $validated['id'])->firstOrFail();

        $taskNote->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => $validated['status'] === 'done' ? 'Task completed successfully.' : 'Task reopened successfully.',
            'html' => view('admin.tasknote.partials.note-card', [
                'note'   => $taskNote,
                'topics' => $topics,
            ])->render(),
        ]);
    }
}
