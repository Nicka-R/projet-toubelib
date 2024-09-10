<?php
namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\RendezVousDTO;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\services\praticien\ServicePraticienInterface;

class ServiceRendezVous implements ServiceRendezVousInterface
{
    private RdvRepositoryInterface $rdvRepository;
    private ServicePraticienInterface $servicePraticien;

    public function __construct(RdvRepositoryInterface $rdvRepository, ServicePraticienInterface $servicePraticien)
    {
        $this->rdvRepository = $rdvRepository;
        $this->servicePraticien = $servicePraticien;
    }

    public function getRendezVousById(string $id): RendezVousDTO
    {
        try {
            $rendezVous = $this->rdvRepository->getRendezVousById($id);
            $praticienDTO = $this->servicePraticien->getPraticienById($rendezVous->getPraticienId());
            return new RendezVousDTO($rendezVous, $praticienDTO);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRendezVousInvalidDataException('Invalid RendezVous ID');
        }
    }
}