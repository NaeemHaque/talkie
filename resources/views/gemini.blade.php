@extends('layouts.app')

@section('title', 'Talkie - Modern Chat')

@section('content')
    <!-- Chat Messages Area -->
    <div id="messages" class="flex-1 mb-2 space-y-6 max-h-[60vh] overflow-y-auto">

        @if(!isset($conversations) || $conversations->isEmpty())
            <x-welcome-message />
            <x-example-prompts />
        @else
            <x-conversations-list :conversations="$conversations" />
        @endif

        <x-legacy-support />
    </div>

    <x-chat-input />
@endsection
