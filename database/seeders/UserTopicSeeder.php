<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = Topic::all();
        User::All()->each(function ($user) use ($topics){
            $user->topics()->saveMany($topics);
        });
    }
}
