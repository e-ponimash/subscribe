<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Http\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Topic;
use App\Services\Subscribe\SubscribeService;
use Exception;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    /**
     * @param $request
     * @param $response
     */
    private function validateRequest($request, $response){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            $response->setError('400', 'ValidateError', 'Email не прошел валидацию');
        }
    }

    /**
     * @param Request $request
     * @param Topic $topic
     * @param SubscribeService $subscribeService
     * @return ApiResponse
     */
    public function subscribeByEmail(Request $request, Topic $topic, SubscribeService $subscribeService): ApiResponse
    {
        $response = new ApiResponse();
        $this->validateRequest($request, $response);
        try {
            $subscribeService->subscribeByEmail($topic, $request->input('email'));
            $response->setData(['success' => true]);
        } catch (Exception $exception){
            $response->setError('400', 'ErrorSubscribe', 'Ошибка при добавлении подписки');
        }
        return $response;
    }

    /**
     * @param Request $request
     * @param Topic $topic
     * @param SubscribeService $subscribeService
     * @return ApiResponse
     */
    public function unsubscribeFromTopic(Request $request, Topic $topic, SubscribeService $subscribeService)
    {
        $response = new ApiResponse();
        $this->validateRequest($request, $response);
        try{
            $subscribeService->unsubscribeFromTopic($topic, $request->input('email'));
            $response->setData(['success' => true]);
        } catch (Exception $exception){
            $response->setError('400', 'ErrorSubscribe', 'Ошибка при удалении подписки');
        }
        return $response;
    }

    /**
     * @param Request $request
     * @param SubscribeService $subscribeService
     * @return ApiResponse
     */
    public function unsubscribeFromAllTopic(Request $request, SubscribeService $subscribeService): ApiResponse
    {
        $response = new ApiResponse();
        $this->validateRequest($request, $response);

        try{
            $subscribeService->unsubscribeFromAllTopic($request->input('email'));
            $response->setData(['success' => true]);
        } catch (Exception $exception){
            $response->setError('400', 'ErrorSubscribe', 'Ошибка при удалении подписок');
        }
        return $response;
    }

    /**
     * @param Request $request
     * @param SubscribeService $subscribeService
     * @return ApiResponse
     */
    public function showSubscriptionsFromUser(Request $request, SubscribeService $subscribeService): ApiResponse
    {
        $validator = Validator::make($request->all(), [
            'offset'=> 'nullable|integer',
            'limit'=> 'nullable|integer'
        ]);

        $response = new ApiResponse();

        if ($validator->fails()) {
            $response->setError('400', 'ValidateError', 'Даннные не прошли валидацию');
            return $response;
        }

        $subscriptions = $subscribeService->getSubscriptionsByUser(Auth::user(), $request->get('offset', 0), $request->get('limit',20));

        $response->setData(['subscriptions' => $subscriptions->toArray()]);
        return $response;

    }

    /**
     * @param Topic $topic
     * @param SubscribeService $subscribeService
     * @param Request $request
     * @return ApiResponse
     */
    public function showUsersBySubscription(Topic $topic, SubscribeService $subscribeService, Request $request): ApiResponse
    {
        $validator = Validator::make($request->all(), [
            'offset'=> 'nullable|integer',
            'limit'=> 'nullable|integer'
        ]);

        $response = new ApiResponse();
        if ($validator->fails()) {
            $response->setError('400', 'ValidateError', 'Даннные не прошли валидацию');
            return $response;
        }

        $users = $subscribeService->getUsersBySubscription($topic, $request->get('offset',0), $request->get('limit',20));
        $response->setData(['users' => $users->toArray()]);
        return $response;
    }
}
