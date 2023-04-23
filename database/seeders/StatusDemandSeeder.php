<?php

namespace Database\Seeders;

use App\Models\StatusDemand;
use Illuminate\Database\Seeder;

class StatusDemandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        StatusDemand::create(['title' => 'Pendente', 'codename' => 'warning']);
        StatusDemand::create(['title' => 'Andamento', 'codename' => 'info']);
        StatusDemand::create(['title' => 'Concluído', 'codename' => 'success']);
        StatusDemand::create(['title' => 'Cancelado', 'codename' => 'danger']);
    }
}
