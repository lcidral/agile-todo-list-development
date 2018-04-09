<?php

use Slim\Http\Request;
use Slim\Http\Response;


$app->get('/tasks/', function ($request, $response)
{
    $result = $this->get('tasks')->getAll();

    return $response->withJson($result);
});

$app->get('/task/[{uuid}]', function ($request, $response, $uuid)
{
    $result = $this->get('tasks')->getTask($uuid);

    return $response->withJson($result);
});

$app->post('/tasks/', function ($request, $response)
{
    $result = $this->get('tasks')->save($request->getParsedBody());

    return $response->withJson($result);
});

$app->delete('/task/[{uuid}]', function ($request, $response, $uuid)
{
    $result = $this->get('tasks')->delete($uuid);

    return $response->withJson($result);
});

$app->put('/task/[{uuid}]', function ($request, $response, $param)
{
    $result = $this->get('tasks')->update(
        $param['uuid'],
        $request->getParsedBody()
    );

    return $response->withJson($result);
});

$app->patch('/task/reorder/[{uuid}]', function ($request, $response, $param)
{
    $data = $request->getParsedBody();
    $sort_order = $data['sort_order'];
    $result = $this->get('tasks')->reorder($param['uuid'], $sort_order);

    return $response->withJson($result);
});