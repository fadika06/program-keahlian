<?php

namespace Bantenprov\ProgramKeahlian\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The ProgramKeahlian facade.
 *
 * @package Bantenprov\ProgramKeahlian
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProgramKeahlianFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'program-keahlian';
    }
}
