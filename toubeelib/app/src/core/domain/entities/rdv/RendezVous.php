<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\RendezVousDTO;


class RendezVous extends Entity{
    protected string $praticien;
    protected string $patient;
    protected string $date;
    protected bool $type;
    protected bool $newPatient;
    protected ?Specialite $specialite = null;

    public function __construct(string $praticien, string $patient, string $date, bool $type, bool $newPatient)
    {
        $this->praticien = $praticien;
        $this->patient = $patient;
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