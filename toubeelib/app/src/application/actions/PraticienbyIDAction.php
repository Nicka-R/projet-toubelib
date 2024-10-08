<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\praticien\ServicePraticienNotFoundException;

class PraticienbyIDAction extends AbstractAction
{
    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticienInterface $servicePraticien) {
        $this->servicePraticien = $servicePraticien;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        $id = (string) $args['id'];

        try {
            $praticienDto = $this->servicePraticien->getPraticienById($id);
            $responseData = [
                'self' => "/praticiens/{$praticienDto->getId()}",
                'nom' => $praticienDto->getNom(),
                'prenom' => $praticienDto->getPrenom(),
                'adresse' => $praticienDto->getAdresse(),
                'tel' => $praticienDto->getTel(),
                'specialite' => $praticienDto->getSpecialite()
            ];
            return JsonRenderer::render($rs, 200, $responseData);

        } catch (ServicePraticienNotFoundException $e) {
            return JsonRenderer::render($rs, 404, ['error' => $e->getMessage()]);
        }
    }
}
