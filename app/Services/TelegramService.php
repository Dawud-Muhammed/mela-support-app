<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $botToken;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
    }

    public function sendMessage($chatId, $message)
    {
        if (!$this->botToken || !$chatId) {
            return false;
        }

        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        try {
            // 🚨 ADDED withoutVerifying() to bypass local server SSL blocks!
            $response = Http::withoutVerifying()->post($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Telegram API Error: ' . $e->getMessage());
            return false;
        }
    }
}