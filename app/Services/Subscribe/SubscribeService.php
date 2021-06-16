<?php

namespace App\Services\Subscribe;
use App\Models\User;


class SubscribeService implements SubscribeInterface
{
    /**
     * @param $topic
     * @param $email
     */
    public function subscribeByEmail($topic, $email)
    {
        $user = User::where(['email' => $email])->firstOrFail();
        $user->topics()->attach([$topic->id]);
    }

    /**
     * @param $topic
     * @param $email
     */
    public function unsubscribeFromTopic($topic, $email)
    {
        $user = User::where(['email' => $email])->firstOrFail();
        $user->topics()->detach($topic->id);
    }

    /**
     * @param $email
     */
    public function unsubscribeFromAllTopic($email)
    {
        $user = User::where(['email' => $email])->firstOrFail();
        $user->topics()->detach();
    }

    /**
     * @param $user
     * @param $offset
     * @param $limit
     * @return mixed
     */
    public function getSubscriptionsByUser($user, $offset, $limit)
    {
        $topics = $user->topics()->skip($offset)->take($limit)->get();
        return $topics;
    }

    /**
     * @param $topic
     * @param $offset
     * @param $limit
     * @return mixed
     */
    public function getUsersBySubscription($topic, $offset, $limit)
    {
        $users = $topic->users()->skip($offset)->take($limit)->get();
        return $users;
    }
}
