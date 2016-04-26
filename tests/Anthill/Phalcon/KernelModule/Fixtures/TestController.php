<?php

namespace Tests\Anthill\Phalcon\KernelModule\Fixtures;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

class TestController extends Controller
{
    public function indexAction()
    {
        return new Response('asd');
    }
}