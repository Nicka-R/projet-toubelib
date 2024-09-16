<?php
namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\RendezVousDTO;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\services\rdv\ServiceRdvInterface;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\dto\SpecialiteDTO;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\services\rdv\ServiceRendezVousInvalidDataException;

class ServiceRdv implements ServiceRdvInterface
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
            $praticienDTO = $this->servicePraticien->getPraticienById($rendezVous->getPraticienID());
            return new RendezVousDTO($rendezVous, $praticienDTO);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRendezVousInvalidDataException('Invalid RendezVous ID');
        }
    }

    public function creerRendezVous(RendezVousDTO $rendezVousDTO): RendezVousDTO
    {
        try {

            $praticienDTO = $this->servicePraticien->getPraticienById($rendezVousDTO->getPraticienID());;

            // $specialite = $this->servicePraticien->getSpecialiteById($rendezVousDTO->getSpecialiteLabel());
            // if (!$praticien->hasSpecialite($specialite)) {
            //     throw new ServiceRendezVousInvalidDataException('La spécialité indiquée ne fait pas partie des spécialités du praticien');
            // }

            // if (!$this->rdvRepository->isPraticienAvailable($rendezVousDTO->getPraticienID(), $rendezVousDTO->getDate())) {
            //     throw new ServiceRendezVousInvalidDataException('Le praticien n\'est pas disponible à la date et à l\'heure demandées');
            // }

            $rendezVous = new RendezVous(
                $rendezVousDTO->getPraticienID(),
                $rendezVousDTO->getPatientID(),
                $rendezVousDTO->getSpecialiteID(),
                $rendezVousDTO->getDate(),
                // $rendezVousDTO->getType(),
                // $rendezVousDTO->isNewPatient()
            );
            // $rendezVous->setSpecialite($specialite);
            $this->rdvRepository->save($rendezVous);

            return new RendezVousDTO($rendezVous, $praticienDTO);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRendezVousInvalidDataException('Invalid data provided');
        }
    }

    /** récupérer la spécialité par son id
     * @param string $id
     * @return SpecialiteDTO
     */
    public function getSpecialiteById(string $id): SpecialiteDTO
    {
        try {
            $specialite = $this->servicePraticien->getSpecialiteById($id);
            return $specialite;
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRendezVousInvalidDataException('Invalid Specialite ID');
        }
    }
}