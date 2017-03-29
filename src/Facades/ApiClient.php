<?php
namespace CivilServices\Api\Facades;

use Illuminate\Support\Facades\Facade;

class ApiClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'civilservices';
    }
}