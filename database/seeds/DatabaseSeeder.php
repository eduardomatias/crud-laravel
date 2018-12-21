<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //esse seeder deve ser executado somente no teste da aplicação base
        $this->call(PovoaTabelaTeste::class);
    }
}
