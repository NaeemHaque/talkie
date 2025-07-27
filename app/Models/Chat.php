<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'title',
        'model',
        'metadata'
    ];

    protected $casts = [
        'metadata'   => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get all conversations for this chat
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get the latest conversation for this chat
     */
    public function latestConversation()
    {
        return $this->hasOne(Conversation::class)->latest();
    }

    /**
     * Get chats by session
     */
    public static function getBySession(string $sessionId)
    {
        return self::where('session_id', $sessionId)
                   ->orderBy('updated_at', 'desc')
                   ->get();
    }

    /**
     * Get the latest chat for a session
     */
    public static function getLatestBySession(string $sessionId)
    {
        return self::where('session_id', $sessionId)
                   ->orderBy('updated_at', 'desc')
                   ->first();
    }

    /**
     * Create a new chat
     */
    public static function createChat(string $sessionId, ?string $title = null, array $metadata = [])
    {
        return self::create([
            'session_id' => $sessionId,
            'title'      => $title,
            'metadata'   => $metadata
        ]);
    }

    /**
     * Update chat title based on first user message
     */
    public function updateTitleFromFirstMessage()
    {
        $firstConversation = $this->conversations()->first();

        if ($firstConversation && $firstConversation->user_message) {
            $title = $this->generateTitleFromMessage($firstConversation->user_message);
            $this->update(['title' => $title]);
        }
    }

    /**
     * Generate a title from user message
     */
    private function generateTitleFromMessage(string $message): string
    {
        $title = trim($message);
        $title = preg_replace('/\s+/', ' ', $title);

        if (strlen($title) > 50) {
            $title = substr($title, 0, 47) . '...';
        }

        return $title ?: 'New Chat';
    }

    /**
     * Get chat with all conversations
     */
    public static function getWithConversations(int $chatId)
    {
        return self::with('conversations')->find($chatId);
    }

    /**
     * Delete chat and all its conversations
     */
    public function deleteChat()
    {
        return $this->delete(); // This will cascade delete conversations
    }
}
