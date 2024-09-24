<?php

namespace toubeelib\core\dto;

use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;

class RendezVousDTO
{
    private string $praticienID;
    private string $patientID;
    private \DateTimeImmutable $date;
    private bool $type;
    private bool $newPatient;
    private string $status;
    private string $specialiteID;
    private string $specialiteLabel;

    public function __construct(RendezVous $rendezVous, PraticienDTO $praticien)
    {
        $this->praticienID = $rendezVous->getPraticienID();
        $this->patientID = $rendezVous->getPatientID();
        $this->specialiteID = $rendezVous->getSpecialiteID();
        $this->date = $rendezVous->getDate();
        $this->status = $rendezVous->getStatus();
        $this->type = $rendezVous->getType();
        $this->newPatient = $rendezVous->isNewPatient();
        $this->specialiteLabel = $rendezVous->getSpecialite() ? $rendezVous->getSpecialite()->getLabel() : 'Pas de Specialite';
    }

    /*
     * Getters et setters
     */
    public function getPraticienID(): string 
    { 
        return $this->praticienID; 
    }
    public function getPatientID(): string
    { 
        return $this->patientID;
    }
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getSpecialiteID(): string 
    { 
        return $this->specialiteID;
    } 

    public function getType(): bool 
    { 
        return $this->type; 
    }

    public function isNewPatient(): bool 
    { 
        return $this->newPatient; 
    }

    public function setSpecialite(Specialite $spe): void
    {
        $this->specialiteLabel = $spe->getLabel();
    }

    public function toEntity(): RendezVous
    {
        $rdv = new RendezVous($this->praticienID, $this->patientID, $this->specialiteLabel, $this->date);
        $rdv->setType($this->type);
        $rdv->setNewPatient($this->newPatient);
        $rdv->setStatus($this->status);
        return $rdv;
    }
}