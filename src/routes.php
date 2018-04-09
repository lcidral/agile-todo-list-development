<?php

use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/tasks/', function ($request, $response) {
    $tasks = new \Recruiting\Test\Task($this->get('db'));
    $result = $tasks->getAll();

    return $response->withJson($result);
});

$app->get('/task/[{uuid}]', function ($request, $response, $uuid) {
    $task = new \Recruiting\Test\Task($this->get('db'));
    $result = $task->getTask($uuid);

    return $response->withJson($result);
});

$app->post('/tasks/', function ($request, $response) {
    $data = $request->getParsedBody();
    $task = new \Recruiting\Test\Task($this->get('db'));
    $result = $task->save($data);

    return $response->withJson($result);
});

$app->delete('/task/[{uuid}]', function ($request, $response, $uuid){
    $task = new \Recruiting\Test\Task($this->get('db'));
    $result = $task->delete($uuid);

    return $response->withJson($result);
});

$app->put('/task/[{uuid}]', function ($request, $response, $param) {
    $task = new \Recruiting\Test\Task($this->get('db'));
    $data = $request->getParsedBody();
    $uuid = $param['uuid'];
    $result = $task->update($uuid, $data);

    return $response->withJson($result);
});

$app->patch('/task/reorder/[{uuid}]', function ($request, $response, $param) {
    $data = $request->getParsedBody();

    $uuid = $param['uuid'];
    $sort_order = $data['sort_order'];

    $task = new \Recruiting\Test\Task($this->get('db'));
    $result = $task->reorder($uuid, $sort_order);

    return $response->withJson($result);
});