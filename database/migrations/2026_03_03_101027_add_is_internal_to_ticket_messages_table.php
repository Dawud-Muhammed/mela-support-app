<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🚨 Changed 'messages' to 'ticket_messages'
        Schema::table('ticket_messages', function (Blueprint $table) { 
            $table->boolean('is_internal')->default(false)->after('message');
        });
    }

    public function down(): void
    {
        // 🚨 Changed 'messages' to 'ticket_messages'
        Schema::table('ticket_messages', function (Blueprint $table) {
            $table->dropColumn('is_internal');
        });
    }
};
