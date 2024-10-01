<?php

namespace toubeelib\infrastructure\repositories;

use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\patient\Patient;
use toubeelib\core\domain\entities\patient\Specialite;
use toubeelib\core\repositoryInterfaces\PatientRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ArrayPatientRepository implements PatientRepositoryInterface
{
    private array $patients = [];

    public function __construct() {
        $this->patients['p1'] = new Patient( 'Dupont', 'Jean', 'nancy', '0123456789');
        $this->patients['p1']->setID('p1');

        $this->patients['p2'] = new Patient( 'Durand', 'Pierre', 'vandeuve', '0123456789');
        $this->patients['p2']->setID('p2');

        $this->patients['p3'] = new Patient( 'Martin', 'Marie', '3lassou', '0123456789');
        $this->patients['p3']->setID('p3');

    }
    public function save(Patient $patient): string
    {
        // TODO : prévoir le cas d'une mise à jour - le patient possède déjà un ID
		$ID = Uuid::uuid4()->toString();
        $patient->setID($ID);
        $this->patients[$ID] = $patient;
        return $ID;
    }

    public function getPatientById(string $id): Patient
    {
        $patient = $this->patients[$id] ??
            throw new RepositoryEntityNotFoundException("Patient $id not found");

        return $patient;
    }
}