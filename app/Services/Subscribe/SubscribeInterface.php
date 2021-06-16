<?php


namespace App\Services\Subscribe;


interface SubscribeInterface
{
    public function subscribeByEmail($topic, $email);
    public function unsubscribeFromTopic($topic, $email);
    public function unsubscribeFromAllTopic($email);
    public function getSubscriptionsByUser($user, $offset, $limit);
    public function getUsersBySubscription($topic, $offset, $limit);
}
