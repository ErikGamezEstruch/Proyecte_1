<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Projectes;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Comentari;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        // CLIENTS
        $clients = Client::factory()->count(3)->create();

        Client::factory()->create([
            'actiu' => false
        ]);

        // ADMIN
        User::factory()->create([
            'name' => 'Admin',
            'email'=> 'admin@admin.com',
            'rol' => 'ADMIN',
            'password' => bcrypt('ies'),
        ]);

        // GESTORS
        $gestors = User::factory()->count(2)->create([
            'rol'=>'GESTOR'
        ]);

        // DEVS
        User::factory()->count(4)->create([
            'rol'=>'DESENVOLUPADOR',
            'tarifa_hora'=>fake()->randomFloat(2, 20, 60)
        ]);

        // USERS CLIENT
        User::factory()->count(3)->create([
            'rol'=>'CLIENT',
            'client_id'=> $clients->random()->id
        ]);

        // PROJECTES
        Projectes::factory()->count(10)->create([
            'client_id' => $clients->random()->id,
            'gestor_id' => $gestors->random()->id
        ]);

        // TICKETS
        $projectes = Projectes::all();
        $users = User::all();
        foreach ($projectes as $projecte) {
            $tickets = Ticket::factory()->count(rand(2,3))->create([
                'projecte_id' => $projecte->id,
                'creador_id' => $users->random()->id,
                'user_id' => $users->random()->id,
            ]);

            foreach ($tickets as $ticket) {

                Comentari::factory()->count(rand(0,4))->create([
                    'ticket_id' => $ticket->id,
                    'autor_id' => $users->random()->id,
                ]);
            }
        }
        // COMENTARIS
        foreach ($tickets as $ticket) {

            Comentari::factory()->count(rand(0,4))->create([
                'ticket_id' => $ticket->id,
                'autor_id' => $users->random()->id,
            ]);
        }
    }
}
