<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ChatHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function interactWithChatbot(Request $request)
    {
        // الرسالة المدخلة من المستخدم
        $userMessage = $request->input('message');

        // رابط Flask API
        $flaskUrl =  "http://127.0.0.1:5000/chat";

        try {
            // إرسال الطلب لـ Flask API
            $response = Http::post($flaskUrl, [
                'message' => $userMessage,
            ]);


            // الحصول على الرد
            $botReply = $response->json()['response'] ?? 'No reply';

            // حفظ الرسالة والرد في قاعدة البيانات
            ChatHistory::create([
                'user_message' => $userMessage,
                'bot_reply' => $botReply,
            ]);



            return response()->json(['reply' => $botReply], 200, [], JSON_UNESCAPED_UNICODE);


        } catch (\Exception $e) {
            // في حالة حدوث خطأ
            return response()->json([
                'error' => 'Failed to connect to Chatbot API',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ChatHistory $chatHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChatHistory $chatHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChatHistory $chatHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChatHistory $chatHistory)
    {
        //
    }
}
