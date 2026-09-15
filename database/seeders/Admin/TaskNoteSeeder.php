<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\TaskNote;
use App\Models\Admin\TaskNoteTopic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::findOrFail(2);

        $topicNames = ['General', 'Work', 'Ideas'];

        $statuses = ['todo', 'progress', 'done'];
        $priorities = ['low', 'medium', 'high', 'urgent'];

        foreach ($topicNames as $name) {
            $topic = TaskNoteTopic::create([
                'user_id' => $user->id,
                'name' => $name,
            ]);

            for ($i = 1; $i <= 5; $i++) {
                TaskNote::create([
                    'user_id' => $user->id,
                    'topic_id' => $topic->id,
                    'title' => "{$name} note {$i}",
                    'content' => "<p>This is sample content for {$name} note {$i}.</p>",
                    'status' => $statuses[array_rand($statuses)],
                    'priority' => $priorities[array_rand($priorities)],
                    'reminder_at' => rand(0, 1) ? now()->addDays(rand(-5, 10)) : null,
                ]);
            }
        }
    }
}
