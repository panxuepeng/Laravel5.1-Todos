<?php
namespace App\Supports\Facades;

use Illuminate\Support\Facades\Facade;

class Cms extends Facade {

    protected static function getFacadeAccessor() { return 'cms'; }

}