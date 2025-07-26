@props(['conversations'])

<!-- Conversation History -->
@foreach($conversations as $conversation)
    <x-user-message 
        :message="$conversation->user_message"
        :timestamp="$conversation->created_at->format('H:i')"
        :filename="$conversation->metadata['filename'] ?? null"
    />

    @if($conversation->ai_response)
        <x-ai-message 
            :response="$conversation->ai_response"
            :timestamp="$conversation->created_at->format('H:i')"
        />
    @else
        <x-ai-message loading="true" />
    @endif
@endforeach