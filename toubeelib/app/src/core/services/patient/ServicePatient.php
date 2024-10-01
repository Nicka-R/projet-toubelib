<?php

namespace toubeelib\core\services\patient;

use Respect\Validation\Exceptions\NestedValidationException;
use toubeelib\core\domain\entities\patient\Patient;
use toubeelib\core\dto\InputPatientDTO;
use toubeelib\core\dto\PatientDTO;
use toubeelib\core\dto\SpecialiteDTO;
use toubeelib\core\repositoryInterfaces\PatientRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ServicePatient implements ServicePatientInterface
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * fonction permettant de créer un patient avec les données fournies dans le DTO
     * @param InputPatientDTO $p les données du patient
     * @throws ServicePatientInvalidDataException si les données du patient ne sont pas valides
     */
    public function createPatient(InputPatientDTO $p): PatientDTO
    {
        $patient = new Patient($p->nom, $p->prenom, $p->adresse, $p->tel, $p->specialite);
        
        $this->patientRepository->save($patient);
        return new PatientDTO($patient);
    }

    /**
     * fonction permettant de récupérer un patient par son ID
     * @param string $id l'ID du patient
     * @throws ServicePatientInvalidDataException si l'ID n'est pas valide
     */
    public function getPatientById(string $id): PatientDTO
    {
        try {
            $patient = $this->patientRepository->getPatientById($id);
            return new PatientDTO($patient);
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServicePatientInvalidDataException('Invalid Patient ID');
        }
    }
}