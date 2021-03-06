<?php

namespace AnvarGear\States;

use Illuminate\Support\Facades\Facade;

class StatesFacade extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'colombia';
    }
}