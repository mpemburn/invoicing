<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AppAuthService {
    protected $user;

    /**
     * init
     *
     * Initialize properties with data pulled from the logged-in user
     *
     * @return void
     */
    public function init()
    {
        $success = false;
        $this->user = Auth::user();
        return $success;
    }

    public function isMemberOf($role_name)
    {
        return ($this->init()) ? $this->user->hasRole($role_name) : false;
    }

}