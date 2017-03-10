<?php

namespace CivilServices\Api;

use Illuminate\Support\Facades\Facade;

class CivilServicesFacade extends Facade
{
    protected static function getFacadeAccessor() {
        return 'civilservices';
    }
}