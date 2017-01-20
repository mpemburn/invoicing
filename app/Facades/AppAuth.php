<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AppAuth extends Facade {
    protected static function getFacadeAccessor() { return 'AppAuthService'; }
}
