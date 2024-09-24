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
use toubeelib\core\dto\InputRdvDTO;
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

    public function creerRendezVous(InputRdvDTO $inputRDV): RendezVousDTO
    {
        try {

            $praticienDTO = $this->servicePraticien->getPraticienById($inputRDV->praticien_id);
            $specialiteDTO = $this->getSpecialiteById($inputRDV->specialite_id);
            if (!$specialiteDTO) {
                throw new ServiceRendezVousInvalidDataException('Invalid Specialite ID');
            }

            $rendezVous = new RendezVous(
                $inputRDV->praticien_id,
                $inputRDV->patient_id,
                $inputRDV->specialite_id,
                $inputRDV->date
            );
            $rendezVous->setType($inputRDV->type);
            $rendezVous->setNewPatient($inputRDV->newPatient);

            $rendezVous->setSpecialite($specialiteDTO->toEntity());
            $this->rdvRepository->save($rendezVous);

            return new RendezVousDTO($rendezVous, $praticienDTO);
        }catch(ServiceRendezVousInvalidDataException $e){
            throw new ServiceRendezVousInvalidDataException('Invalid specialite');
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