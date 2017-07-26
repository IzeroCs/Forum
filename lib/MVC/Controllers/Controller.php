<?php

    namespace Lib\MVC\Controllers;

    use Lib\MVC\Views\View;

    abstract class Controller extends View
    {

        public abstract function index();

    }
