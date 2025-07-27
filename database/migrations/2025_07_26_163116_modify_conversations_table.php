<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing conversations table completely
        Schema::dropIfExists('conversations');
        
        // Create the new conversations table with chat_id structure
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->text('user_message');
            $table->longText('ai_response')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
        
        // Recreate the old conversations table structure
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->text('user_message');
            $table->longText('ai_response')->nullable();
            $table->string('model')->default('gemini-2.0-flash');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }
}; 