<?php

    namespace Controller;

    use Lib\MVC\Controllers\Controller;

    class HomeController extends Controller
    {

        public function index()
        {
            return $this->view('home');
        }

    }
