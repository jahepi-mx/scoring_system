<?php
namespace App\Http\Controllers;


class TestController extends Controller
{

    public function test() {
        return $this->render('test', []);
    }

}
