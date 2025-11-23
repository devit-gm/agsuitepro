<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ficha;
use Illuminate\Support\Str;

class MesasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 20 mesas iniciales en estado libre
        // user_id = 1 por defecto (ajustar si necesitas otro usuario)
        for ($i = 1; $i <= 20; $i++) {
            \DB::connection('site')->table('fichas')->insert([
                'uuid' => (string) Str::uuid(),
                'user_id' => 1,
                'tipo' => 1,
                'estado' => 1,
                'invitados_grupo' => 0,
                'fecha' => now()->toDateString(),
                'precio' => 0,
                'numero_mesa' => (string) $i,
                'modo' => 'mesa',
                'estado_mesa' => 'libre',
                'numero_comensales' => 0,
                'descripcion' => 'Mesa ' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Se han creado 20 mesas correctamente.');
    }
}
