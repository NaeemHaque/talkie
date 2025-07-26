<!-- Legacy Support - Keep existing $response logic for backward compatibility -->
@if(isset($response) && (!isset($conversations) || $conversations->isEmpty()))
    <x-user-message 
        :message="$last_prompt ?? 'Your message'"
        timestamp=""
    />

    <x-ai-message 
        :response="$response"
        timestamp=""
    />
@endif