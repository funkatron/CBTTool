<?php
use CBTTool\Model\Thinkingmistake;
use CBTTool\Model\Thoughtrecord;

$app->error(function (\Exception $e) use ($app) {
    $app->log->addError("Exception thrown: " . $e->getMessage());
    $app->render('pages/error.html', 500);
});

$app->get('/', function () use ($app) {
    $tm = new Thinkingmistake($app->getConfig());
    $rows = $tm->getAll(100,0);
    $app->render('pages/index.html', array(
                     'thinking_mistakes' => $rows
                 ));
});

$app->post('/', function () use ($app) {
    // form post of data from tool. Generate ID and save it in DB. redirect to
    // /saved/:id
    $input['event'] = $app->request->post('event');
    $input['thoughts'] = $app->request->post('thoughts');
    $input['feelings'] = $app->request->post('feelings');
    $input['behaviors'] = $app->request->post('behaviors');
    $input['thoughts_accurate'] = $app->request->post('thoughts_accurate');
    $input['thoughts_helpful'] = $app->request->post('thoughts_helpful');
    $input['thinking_mistake_id'] = $app->request->post('thinking_mistake_id');
    $input['say_to_self'] = $app->request->post('say_to_self');
    $input['how_feel'] = $app->request->post('how_feel');

    $tr = new Thoughtrecord($app->getConfig());
    $new_id = $tr->save($input);
    $row = $tr->getById($new_id);
    $id_hash = $row['id_hash'];

    $app->redirect($app->request->getRootUri()."/saved/{$id_hash}");
});

$app->get('/saved/:id', function ($saved_id) use ($app) {
    // display "frozen" version of form
    $tr = new Thoughtrecord($app->getConfig());
    $row = $tr->getByHash($saved_id);
    $app->render('pages/saved.html', $row);
})->conditions(array('id' => '([a-f0-9]+)'));
