<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_message',
        'ai_response',
        'model',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get conversations grouped by session
     */
    public static function getBySession(string $sessionId)
    {
        return self::where('session_id', $sessionId)
                   ->orderBy('created_at', 'asc')
                   ->get();
    }

    /**
     * Get the latest conversations for a session
     */
    public static function getLatestBySession(string $sessionId, int $limit = 50)
    {
        return self::where('session_id', $sessionId)
                   ->orderBy('created_at', 'desc')
                   ->limit($limit)
                   ->get()
                   ->reverse();
    }

    /**
     * Create a new conversation entry
     */
    public static function createEntry(string $sessionId, string $userMessage, ?string $aiResponse = null, array $metadata = [])
    {
        return self::create([
            'session_id' => $sessionId,
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
}
