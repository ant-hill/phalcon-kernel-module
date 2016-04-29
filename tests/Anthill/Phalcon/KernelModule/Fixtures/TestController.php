<?php

namespace Tests\Anthill\Phalcon\KernelModule\Fixtures;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;

/**
 * @RoutePrefix("/robots")
 */
class TestController extends Controller
{
    public function indexAction()
    {
        return new Response('asd');
    }

    /**
     * @Post("/qwe_index")
     */
    public function asdAction()
    {
        return new Response('asd');
    }

    /**
     * @Post("/qwe_index")
     */
    public function qweAction()
    {
        return new Response('asd');
    }
}