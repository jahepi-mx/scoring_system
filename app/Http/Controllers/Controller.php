<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //

    public function render($view, $data) {
        return view('template.body', $data, ['body_view' => $view]);
    }
}
