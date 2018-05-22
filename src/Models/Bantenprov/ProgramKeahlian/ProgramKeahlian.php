<?php

namespace Bantenprov\ProgramKeahlian\Models\Bantenprov\ProgramKeahlian;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramKeahlian extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'program_keahlians';
    protected $fillable = [
        'label',
        'keterangan',
        'user_id',
    ];
    protected $hidden = [
        //
    ];
    protected $appends = [
        //
    ];
    protected $dates = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
 }
