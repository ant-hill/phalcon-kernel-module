<?php
/**
 * Local variables
 * @var \Phalcon\Mvc\Micro $app
 */

$app->map('/', function () use ($app) {
    echo 'Hello World!';
});

$app->map('/asd', function () use ($app) {
    return new \Phalcon\Http\Response('Asd');
});

/**
 * Not found handler
 */
$app->notFound(function () use ($app) {
    echo 'Not Found';
});
