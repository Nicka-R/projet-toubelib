<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use \toubeelib\application\actions\ModifierRDVAction;
use \toubeelib\application\actions\RDVbyIDAction;
use \toubeelib\application\actions\HomeAction;

return function(App $app): App {

    $app->get('/', HomeAction::class);

    $app->get('/rdvs/{id}', RDVbyIDAction::class);

    $app->patch('/rdvs/{id}/modifier', ModifierRDVAction::class);


    return $app;
};