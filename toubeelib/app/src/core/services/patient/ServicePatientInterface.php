<?php

namespace toubeelib\core\services\patient;

use toubeelib\core\dto\InputPatientDTO;
use toubeelib\core\dto\PatientDTO;

interface ServicePatientInterface
{

    public function createPatient(InputPatientDTO $p): PatientDTO;
    public function getPatientById(string $id): PatientDTO;
}