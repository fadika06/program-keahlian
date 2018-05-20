<?php

Route::group(['prefix' => 'api/program-keahlian', 'middleware' => ['auth', 'role:superadministrator']], function() {
    $class          = 'Bantenprov\ProgramKeahlian\Http\Controllers\ProgramKeahlianController';
    $name           = 'program-keahlian';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];

    Route::get('/',             $controllers->index)->name($name.'.index')->middleware('role:superadministrator');
    Route::get('/get',          $controllers->get)->name($name.'.get')->middleware('role:superadministrator');
    Route::get('/create',       $controllers->create)->name($name.'.create')->middleware('role:superadministrator');
    Route::post('/',            $controllers->store)->name($name.'.store')->middleware('role:superadministrator');
    Route::get('/{id}',         $controllers->show)->name($name.'.show')->middleware('role:superadministrator');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit')->middleware('role:superadministrator');
    Route::put('/{id}',         $controllers->update)->name($name.'.update')->middleware('role:superadministrator');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy')->middleware('role:superadministrator');
});
