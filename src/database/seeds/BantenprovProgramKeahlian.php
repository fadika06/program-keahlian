<?php

use Illuminate\Database\Seeder;

class BantenprovProgramKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BantenprovProgramKeahlianSeederProgramKeahlian::class);
    }
}
