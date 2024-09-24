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

    /** 
     * fonction permettant de créer un rendez-vous avec les données fournies dans le DTO
     * @param InputRdvDTO $inputRDV les données du rendez-vous
     * @throws ServiceRendezVousInvalidDataException si les données du rendez-vous ne sont pas valides
     * @return RendezVousDTO
     */

    public function creerRendezVous(InputRdvDTO $inputRDV): RendezVousDTO
    {
        try {

            $praticienDTO = $this->servicePraticien->getPraticienById($inputRDV->praticien_id);
            //vérifier que le praticien soit disponible
            if (!$this->isPraticienAvailable($inputRDV->praticien_id, $inputRDV->date)) {
                throw new ServiceRendezVousInvalidDataException('Praticien non disponible');
            }
            $specialiteDTO = $this->getSpecialiteById($inputRDV->specialite_id);
            if (!$specialiteDTO) {
                throw new ServiceRendezVousInvalidDataException('Invalid Specialite ID');
            }

            //vérifier que les spécialités du praticien correspondent à celles du rendez-vous
            // echo "specialite du rendez-vous : ".$inputRDV->specialite_id."\n";
            if (!$this->checkPraticienSpecialites($inputRDV->praticien_id, $inputRDV->specialite_id)) {
                throw new ServiceRendezVousInvalidDataException('Praticien ne possède pas la spécialité requise');
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
            throw new ServiceRendezVousInvalidDataException('Création de rendez-vous impossible');
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

    /**
     * vérifie la disponibilité d'un praticien à une date donnée
     * @param string $praticien_id
     * @param \DateTimeImmutable $date
     * @return bool
     */
    public function isPraticienAvailable(string $praticien_id, \DateTimeImmutable $date): bool
    {
        $rendezVous = $this->rdvRepository->getRendezVousByPraticienAndDate($praticien_id, $date);
        
        return empty($rendezVous);
    }

    /**
     * fonction qui permet de vérifier que les spécialités du praticien correspondent à celles du rendez-vous
     * @param string $praticienId l'ID du praticien
     * @param string $specialite la liste des spécialités requises pour le rendez-vous
     * @throws ServicePraticienInvalidDataException si l'ID du praticien n'est pas valide
     * @return bool true si toutes les spécialités requises sont présentes, sinon false
     */
    public function checkPraticienSpecialites(string $praticienId, string $specialite): bool
    {
        $spes = $this->servicePraticien->getSpecialitesByPraticienId($praticienId);
        $specialitesPraticienIds = [];
        foreach ($spes as $spe) {
            $specialitesPraticienIds[] = $spe->ID;
        }
        if($specialite === $specialitesPraticienIds[0]){
            return true;
        }
        //compare les spécialités du praticien avec celles du rendez-vous
        return false;

    }

}