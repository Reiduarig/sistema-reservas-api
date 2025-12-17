<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Popular concert - high demand, low availability
        Event::factory()->withLowAvailability()->create([
            'name' => 'Rock Legends World Tour 2025',
            'location' => 'Estadio Nacional, Santiago',
            'price_per_ticket' => 149.99,
            'total_tickets' => 5000,
        ]);

        // Festival - high availability
        Event::factory()->withHighAvailability()->create([
            'name' => 'Festival Electrónico Sunset',
            'location' => 'Parque Bicentenario, Santiago',
            'price_per_ticket' => 79.99,
            'total_tickets' => 2500,
        ]);

        // Premium event - exclusive
        Event::factory()->premium()->create([
            'name' => 'Jazz Masters Intimate Session',
            'location' => 'Teatro Municipal, Valparaíso',
        ]);

        // Tech conference
        Event::factory()->create([
            'name' => 'Laravel Conference Chile 2025',
            'description' => 'La conferencia más importante de Laravel en Latinoamérica. Speakers internacionales, workshops prácticos y networking con la comunidad.',
            'location' => 'Centro de Convenciones, Santiago',
            'price_per_ticket' => 199.99,
            'total_tickets' => 500,
        ]);

        // Sold out event
        Event::factory()->soldOut()->create([
            'name' => 'Pop Stars Arena Show',
            'location' => 'Arena Santiago',
        ]);

        // Completed past event
        Event::factory()->completed()->create([
            'name' => 'Classical Symphony Gala 2024',
            'location' => 'Teatro Nacional, Santiago',
        ]);

        // Cancelled event
        Event::factory()->cancelled()->create([
            'name' => 'Indie Sounds Festival (Cancelado)',
            'location' => "Parque O'Higgins, Santiago",
        ]);

        // Regular events with variety
        Event::factory(3)->create();
    }
}
