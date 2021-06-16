<?php

namespace Tests\Feature;

use App\Models\Topic;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    //api/topics/{topic}/subscribe
    public function testSubscribe()
    {
        $topic = Topic::first();
        $response = $this->post("api/topics/$topic->id/subscribe", ["email"=>"test@tests.com"]);
        $response->assertStatus(200);
        $response->assertJson(json_decode('{"data": {"success": true}}', true));
    }


    //api/topics/{topic}/unsubscribe
    public function testUnsubscribe()
    {
        $topic = Topic::first();
        $user = User::where(['email' => "test@tests.com"])->first();
        $user->topics()->attach([$topic->id]);

        $response = $this->delete("api/topics/$topic->id/unsubscribe", ["email"=>"test@tests.com"]);
        $response->assertStatus(200);
        $response->assertJson(json_decode('{"data": {"success": true}}', true));
    }

    //api/topics/unsubscribe
    public function testUnsubscribeAll()
    {
        $topic = Topic::first();
        $user = User::where(['email' => "test@tests.com"])->first();
        $user->topics()->attach([$topic->id]);

        $response = $this->delete("api/topics/unsubscribe", ["email"=>"test@tests.com"]);
        $response->assertStatus(200);
        $response->assertJson(json_decode('{"data": {"success": true}}', true));
    }

    //api/topics/{topic}/users/list
    public function testGetUserSubscription()
    {
        $topic = Topic::first();
        $user = User::where(['email' => "test@tests.com"])->first();
        $user->topics()->attach([$topic->id]);

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get("api/topics/$topic->id/users/list");
        $response->assertStatus(401);

        Passport::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->get("api/topics/$topic->id/users/list");
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['users'=>['*'=>['id', 'name', 'email']]]]);
        $response->assertJsonPath('data.users.0.email', "test@tests.com");
    }

    //api/topics/users/list
    public function testGetTopicSubscription()
    {
        $topic = Topic::first();
        $user = User::where(['email' => "test@tests.com"])->first();
        $user->topics()->attach([$topic->id]);

        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post('api/topics/users/list');
        $response->assertStatus(401);

        Passport::actingAs($user);
        $response = $this->withHeaders(['Accept' => 'application/json'])
            ->post('api/topics/users/list');
        $response->assertStatus(200);
        $response->assertJsonPath('data.subscriptions.0.name', "topic 1");
        $response->assertJsonStructure(['data' => ['subscriptions'=>['*'=>['id', 'name']]]]);
    }
}
