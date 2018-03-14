<?php

namespace Bantenprov\ProgramKeahlian\Models\Bantenprov\ProgramKeahlian;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramKeahlian extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'program_keahlians';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'label',
        'description',
    ];
}
