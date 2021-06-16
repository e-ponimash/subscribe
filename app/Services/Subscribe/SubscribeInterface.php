<?php


namespace App\Services\Subscribe;


interface SubscribeInterface
{
    public function subscribeByEmail();

    public function unsubscribeFromTopic();

    public function unsubscribeFromAllTopic();

    public function showSubscriptionsFromUser();

    public function showUsersBySubscription();
}
