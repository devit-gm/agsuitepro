<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'All']);

        Permission::create(['name' => 'Ver usuarios']);
        Permission::create(['name' => 'Crear usuarios']);
        Permission::create(['name' => 'Editar usuarios']);
        Permission::create(['name' => 'Borrar usuarios']);

        Permission::create(['name' => 'Ver familias']);
        Permission::create(['name' => 'Crear familias']);
        Permission::create(['name' => 'Editar familias']);
        Permission::create(['name' => 'Borrar familias']);

        Permission::create(['name' => 'Ver productos']);
        Permission::create(['name' => 'Crear productos']);
        Permission::create(['name' => 'Editar productos']);
        Permission::create(['name' => 'Borrar productos']);

        Permission::create(['name' => 'Ver servicios']);
        Permission::create(['name' => 'Crear servicios']);
        Permission::create(['name' => 'Editar servicios']);
        Permission::create(['name' => 'Borrar servicios']);

        Permission::create(['name' => 'Ver usuarios']);
        Permission::create(['name' => 'Crear usuarios']);
        Permission::create(['name' => 'Editar usuarios']);
        Permission::create(['name' => 'Borrar usuarios']);

        Permission::create(['name' => 'Ver fichas']);
        Permission::create(['name' => 'Crear fichas']);
        Permission::create(['name' => 'Editar fichas']);
        Permission::create(['name' => 'Borrar fichas']);

        Permission::create(['name' => 'Ver reservas']);
        Permission::create(['name' => 'Crear reservas']);
        Permission::create(['name' => 'Editar reservas']);
        Permission::create(['name' => 'Borrar reservas']);

        Permission::create(['name' => 'Ver informes']);

        Permission::create(['name' => 'Ver ajustes']);
        Permission::create(['name' => 'Cambiar ajustes']);
    }
}
