<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\application\renderer\JsonRenderer;
use toubeelib\core\services\rdv\ServiceRDVInvalidDataException;

class RDVbyIDAction extends AbstractAction
{
    private ServiceRDVInterface $serviceRDV;

    public function __construct(ServiceRDVInterface $serviceRDV) {
        $this->serviceRDV = $serviceRDV;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        $id = (string) $args['id'];

        try {
            $rdvDTO = $this->serviceRDV->getRDVByID($id);
            $responseData = [
                'self' => "/rdvs/{$rdvDTO->getId()}",
                'praticien' => $rdvDTO->getPraticien(),
                'patient' => $rdvDTO->getPatient(),
                'creneau' => $rdvDTO->getCreneau(),
            ];
            return JsonRenderer::render($rs, 200, $responseData);

        } catch (ServiceRDVInvalidDataException $e) {
            return JsonRenderer::render($rs, 404, ['error' => $e->getMessage()]);
        }
    }
}
