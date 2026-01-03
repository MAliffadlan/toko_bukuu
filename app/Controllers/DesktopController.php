<?php

namespace App\Controllers;

class DesktopController extends BaseController
{
    public function index()
    {
        return view('desktop/index', [
            'title' => 'Desktop'
        ]);
    }
}
