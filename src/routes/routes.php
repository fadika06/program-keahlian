<?php

Route::group(['prefix' => 'api/program-keahlian', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\ProgramKeahlian\Http\Controllers\ProgramKeahlianController@index',
        'create'    => 'Bantenprov\ProgramKeahlian\Http\Controllers\ProgramKeahlianController@create',
        'store'     => 'Bantenprov\ProgramKeahlian\Http\Controllers\ProgramKeahlianController@store',
        'show'      => 'Bantenprov\ProgramKeahlian\Http\Controllers\ProgramKeahlianController@show',
        'edit'      => 'Bantenprov\ProgramKeahlian\Http\Controllers\ProgramKeahlianController@edit',
        'update'    => 'Bantenprov\ProgramKeahlian\Http\Controllers\ProgramKeahlianController@update',
        'destroy'   => 'Bantenprov\ProgramKeahlian\Http\Controllers\ProgramKeahlianController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('program-keahlian.index');
    Route::get('/create',       $controllers->create)->name('program-keahlian.create');
    Route::post('/',            $controllers->store)->name('program-keahlian.store');
    Route::get('/{id}',         $controllers->show)->name('program-keahlian.show');
    Route::get('/{id}/edit',    $controllers->edit)->name('program-keahlian.edit');
    Route::put('/{id}',         $controllers->update)->name('program-keahlian.update');
    Route::delete('/{id}',      $controllers->destroy)->name('program-keahlian.destroy');
});
