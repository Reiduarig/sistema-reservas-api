<?php

use App\Enums\EventStatus;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->dateTime('event_date');
            $table->string('location');
            $table->unsignedInteger('total_tickets');
            $table->unsignedInteger('available_tickets');
            $table->unsignedInteger('reserved_tickets')->default(0);
            $table->decimal('price_per_ticket', 10, 2);
            $table->unsignedInteger('reservation_ttl_minutes')->default(config('reservationFlow.reservation_ttl_minutes'));
            $table->string('status')->default(EventStatus::ACTIVE);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
