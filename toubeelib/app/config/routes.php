<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use \toubeelib\application\actions\ModifierRDVAction;
use \toubeelib\application\actions\RDVbyIDAction;
use \toubeelib\application\actions\HomeAction;
use \toubeelib\application\actions\PraticienbyIDAction;
use \toubeelib\application\actions\AuthAction;
use \app\middlewares\Cors;
use \app\middlewares\CheckJwtToken;	



return function(App $app): App {
    $app->add(Cors::class);
    $app->add(CheckJwtToken::class);

    $app->get('/', HomeAction::class)->setName('home');

    $app->get('/rdvs/{id}', RDVbyIDAction::class)->setName('rdvById');

    $app->patch('/rdvs/{id}/modifier', ModifierRDVAction::class)->setName('modifierRDV');

    $app->get('/praticiens/{id}', PraticienbyIDAction::class)->setName('praticienById');

    $app->get('/auth/signin', AuthAction::class)->setName('authSignin');

    $app->post('/auth/signin', AuthAction::class)->setName('authSignin');

    $app->options('/{routes:.+}', function (Request $request, Response $response) {
        return $response;
    })->add(function (Request $request, RequestHandler $handler) {
        $cors = new Cors();
        return $cors->corsHeaders($request, $handler);
    });

    return $app;
};