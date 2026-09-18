<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\TaskNote;
use App\Models\Admin\TaskNoteTopic;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::findOrFail(2);

        $topics = collect(['General', 'Client work', 'Personal', 'Ideas'])
            ->mapWithKeys(fn($name) => [
                $name => TaskNoteTopic::firstOrCreate([
                    'user_id' => $user->id,
                    'name' => $name,
                ]),
            ]);

        $notes = [
            [
                'title' => 'Finish onboarding doc',
                'content' => '<p>Add the last two sections before Friday. Include the screenshots from the walkthrough.</p>',
                'topic' => 'Client work',
                'status' => 'progress',
                'priority' => 'high',
                'reminder_at' => now()->addDay(),
            ],
            [
                'title' => 'Buy groceries',
                'content' => '<p>Milk, eggs, bread, coffee.</p>',
                'topic' => 'Personal',
                'status' => 'todo',
                'priority' => 'low',
                'reminder_at' => null,
            ],
            [
                'title' => 'Renew domain',
                'content' => '<p>Expires next week — set up auto-renew this time.</p>',
                'topic' => 'General',
                'status' => 'done',
                'priority' => 'urgent',
                'reminder_at' => now()->subHours(3),
                'created_at' => now()->subDay(),
            ],
            [
                'title' => 'Sketch new landing page',
                'content' => '<p>Rough wireframe only — save the polish for after client feedback.</p>',
                'topic' => 'Ideas',
                'status' => 'todo',
                'priority' => 'medium',
                'reminder_at' => null,
                'created_at' => now()->subDays(2),
            ],
            [
                'title' => 'Call accountant',
                'content' => '<p>Ask about the Q3 filing deadline.</p>',
                'topic' => 'Client work',
                'status' => 'progress',
                'priority' => 'medium',
                'reminder_at' => now()->addHours(6),
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($notes as $note) {
            TaskNote::forceCreate([
                'user_id' => $user->id,
                'topic_id' => $topics[$note['topic']]->id,
                'title' => $note['title'],
                'content' => $note['content'],
                'status' => $note['status'],
                'priority' => $note['priority'],
                'reminder_at' => $note['reminder_at'],
                'created_at' => $note['created_at'] ?? now(),
                'updated_at' => $note['created_at'] ?? now(),
            ]);
        }
    }
}
