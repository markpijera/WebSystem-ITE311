<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home - ITE311 Web System'
        ];
        return view('home', $data);
    }
}
