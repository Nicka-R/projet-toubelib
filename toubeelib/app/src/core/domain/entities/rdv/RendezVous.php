<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\RendezVousDTO;


class RendezVous extends Entity{
    protected string $praticienID;
    protected string $patientID;
    protected string $date;
    protected bool $type;
    protected bool $newPatient;
    protected string $status;   // définir un statut
    protected ?Specialite $specialite = null;

    public function __construct(string $praticien, string $patient, string $date, bool $type, bool $newPatient)
    {
        $this->praticienID = $praticien;
        $this->patientID = $patient;
        $this->date = $date;
        $this->type = $type;
        $this->newPatient = $newPatient;
    }

    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function toDTO(): RendezVousDTO
    {
        return new RendezVousDTO($this);
    }


}