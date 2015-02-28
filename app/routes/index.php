<?php
$app->error(function (\Exception $e) use ($app) {
    $app->log->addError("Exception thrown: " . $e->getMessage());
    $app->render('pages/error.html', 500);
});

$app->get('/', function () use ($app) {
    $app->render('pages/index.html');
});

$app->post('/', function () use ($app) {
    // form post of data from tool. Generate ID and save it in DB. redirect to
    // /saved/:id
});

$app->get('/saved/:id', function ($saved_id) use ($app) {
    // display "frozen" version of form
})->conditions(array('year' => '([a-f0-9])'));
