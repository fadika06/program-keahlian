<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\ProgramKeahlian\Models\Bantenprov\ProgramKeahlian\ProgramKeahlian;

class BantenprovProgramKeahlianSeederProgramKeahlian extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $program_keahlians = (object) [
            (object) [
                'user_id'       => '1',
                'label'         => 'label1',
                'keterangan'    => 'keterangan 1'
            ],
            (object) [
                'user_id'       => '2',
                'label'         => 'label2',
                'keterangan'    => 'keterangan2'
            ],
            (object) [
                'user_id'       => '3',
                'label'         => 'label3',
                'keterangan'    => 'keterangan3'
            ],
            
        ];

        foreach ($program_keahlians as $program_keahlian) {
            $model = ProgramKeahlian::updateOrCreate(
                [
                    'label' => $program_keahlian->label
                    'keterangan' => $program_keahlian->keterangan,
                    'user_id'   => $program_keahlian->user_id,
                ]
            );
            $model->save();
        }
    }
}
