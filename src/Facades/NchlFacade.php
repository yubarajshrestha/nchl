<?php

namespace YubarajShrestha\NCHL\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class NchlFacade
 * @package YubarajShrestha\NCHL
 */
class NchlFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nchl';
    }
}