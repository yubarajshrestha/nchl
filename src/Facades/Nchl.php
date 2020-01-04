<?php

namespace YubarajShrestha\NCHL\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Nchl.
 */
class Nchl extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nchl';
    }
}
