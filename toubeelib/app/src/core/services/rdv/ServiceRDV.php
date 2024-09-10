<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\services\rdv\ServiceRDVInvalidDataException;
use toubeelib\core\dto\RDVDTO;

class ServiceRDV extends ServiceRDVInterface {

    private ServicePraticienInterface $praticien;
    private RDVRepositoryInterface $rdvRepository;

    public function __construct(ServicePraticienInterface $praticien, RDVRepositoryInterface $rdvRepository) {
        $this->praticien = $praticien;
        $this->rdvRepository = $rdvRepository;
    } 
    
    public function getRDVById(string $id): RDVDTO
    {
        try {
            $rdv = $this->rdvRepository->getRDVById($id);
            $praticien = $this->praticien->getPraticienById($rdv->idPraticien);
            return new RDVDTO($rdv);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServiceRDVInvalidDataException('invalid RDV ID');
        }
    }



}