<?php
namespace app\middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ChekApiKey {
    public function __invoke(
   ServerRequestInterface $request,
   RequestHandlerInterface $next ): ResponseInterface {
    $routeContext = RouteContext::fromRequest($request);
    $route = $routeContext->getRoute();
    $ressourceId = $route->getArguments()['id'] ;
    $key = $request->getQueryParams()['apikey'] ?? null;
    if (is_null($key))
    throw new HttpBadRequestException($request,'missing api key');
    try {
    $this->apiKeyService->checkApiKeyValidity($ressourceId, $key);
    } catch (ApiKeyServiceInvalidKeyException $e) {
    throw new HttpForbiddenException($request,'invalid api key');
    }
    $request = $request->withAttribute('apikey', $key);
    $response = $next->handle($request);
    return $response;
    }
   }