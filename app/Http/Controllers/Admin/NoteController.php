<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\TaskNote;
use App\Models\Admin\TaskNoteTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Throwable;

class NoteController extends Controller
{
    public function index()
    {
        return view('admin.tasknote.index');
    }

    public function save(Request $request, ?TaskNote $taskNote = null)
    {
        $userId = auth('web')->id();

        // Editing someone else's note should 403, not silently succeed.
        if ($taskNote && $taskNote->user_id !== $userId) {
            abort(403);
        }

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

            return response()->json([
                'success' => true,
                'message' => 'Note saved successfully.',
                'note'    => $taskNote->load('topic'),
            ], 201);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, no changes were saved.',
            ], 500);
        }
    }

    public function addTopic(Request $request){
        $userId = auth('web')->id();
        $validated = $request->validate([
            'name' => ['required', 'string', Rule::unique('task_note_topics', 'name')->where('user_id', $userId)],
        ]);

        DB::beginTransaction();
        try {
            $taskNoteTopic = TaskNoteTopic::create([
                'name' => $validated['name'],
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Topic "{$request->name}" Added ',
            ], 201);
        } catch (Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, no changes were saved.',
            ], 500);
        }
    }




}
