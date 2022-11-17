<?php
namespace App\Http\Controllers;

class RoleController extends Controller
{
    public function __invoke()
    {
        return app('roleService')->options();
    }
}
