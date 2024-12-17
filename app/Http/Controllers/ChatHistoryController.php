<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatHistoryController extends Controller
{

    const RATE_LIMIT = 10;
    const RATE_LIMIT_TIME = 60; // in seconds
    const BAN_TIME = 300; // in seconds
    const FLASK_API_URL = "https://rasclny-ai.kero-dev.tech/chat";
    const API_KEY = '4e652221-891b-42a4-9800-8b03f56cd9fe';

    public function interactWithChatbot(Request $request)
    {
        $ip = $request->ip();
        $rateLimitKey = 'rate_limit_' . $ip;
        $banKey = 'ban_' . $ip;

        if ($this->isBanned($banKey)) {
            return $this->bannedResponse();
        }

        if ($this->hasExceededRateLimit($rateLimitKey, $banKey)) {
            return $this->rateLimitExceededResponse();
        }

        $userMessage = $request->input('message');
        $response = $this->sendMessageToApi($userMessage);

        if ($response->failed()) {
            Log::error('API call failed', ['url' => self::FLASK_API_URL]);
            $message = "Sorry, I'm unable to process your request at the moment. Please try again later.";
            return response()->json(['reply' => $message], 200);

        }

        $botReply = $response->json()['response'] ?? 'No reply';
        ChatHistory::create([
            'user_message' => $userMessage,
            'bot_reply' => $botReply,
        ]);

        return response()->json(['reply' => $botReply], 200, [], JSON_UNESCAPED_UNICODE);
    }

    private function isBanned($banKey)
    {
        return Cache::has($banKey);
    }

    private function bannedResponse()
    {
        $message = "You've reached the rate limit. Please try again later.";
        return response()->json(['reply' => $message], 200);
    }

    private function hasExceededRateLimit($rateLimitKey, $banKey)
    {
        $requestCount = Cache::get($rateLimitKey, 0);
        if ($requestCount >= self::RATE_LIMIT) {
            Cache::put($banKey, true, self::BAN_TIME);
            Cache::forget($rateLimitKey); // Reset rate limit after banning
            return true;
        }
        Cache::put($rateLimitKey, $requestCount + 1, self::RATE_LIMIT_TIME);
        return false;
    }

    private function sendMessageToApi($userMessage)
    {
        return Http::withHeaders(['api-key' => self::API_KEY])
            ->post(self::FLASK_API_URL, ['message' => $userMessage]);
    }


}
