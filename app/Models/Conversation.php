<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_message',
        'ai_response',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the chat that owns this conversation
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Get conversations for a specific chat
     */
    public static function getByChat(int $chatId)
    {
        return self::where('chat_id', $chatId)
                   ->orderBy('created_at', 'asc')
                   ->get();
    }

    /**
     * Get the latest conversations for a chat
     */
    public static function getLatestByChat(int $chatId, int $limit = 50)
    {
        return self::where('chat_id', $chatId)
                   ->orderBy('created_at', 'desc')
                   ->limit($limit)
                   ->get()
                   ->reverse();
    }

    /**
     * Create a new conversation entry
     */
    public static function createEntry(int $chatId, string $userMessage, ?string $aiResponse = null, array $metadata = [])
    {
        return self::create([
            'chat_id' => $chatId,
            'user_message' => $userMessage,
            'ai_response' => $aiResponse,
            'metadata' => $metadata
        ]);
    }

    /**
     * Update AI response for existing conversation
     */
    public function updateResponse(string $response)
    {
        $this->update(['ai_response' => $response]);
        return $this;
    }

    /**
     * Get conversations for building context (last 10 exchanges)
     */
    public static function getContextForChat(int $chatId, int $limit = 10)
    {
        return self::where('chat_id', $chatId)
                   ->orderBy('created_at', 'desc')
                   ->limit($limit)
                   ->get()
                   ->reverse();
    }
}
