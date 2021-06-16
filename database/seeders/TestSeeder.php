<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topic = new Topic();
        $topic->name = 'topic 1';
        $topic->save();

        $user = new User();
        $user->name = 'User';
        $user->email = 'test@tests.com';
        $user->password = bcrypt('1');
        $user->save();
    }
}
