<?php

namespace toubeelib\core\domain\entities\rdv;

use DateTimeImmutable;
use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\RDVDTO;

class RendezVous extends Entity
{
    // protected string $type; //présentiel ou téléconsultation
    // protected string $etatConsult; //réalisée, payée ou transmise aux organismes sociaux
    // protected string $etatPatient; //patient nouveau ou non
    
    protected string $idPraticien;
    protected string $idPatient;
    protected string $specialite_label;
    protected DateTimeImmutable|false $creneau;
    protected string $status; //rdv disponible, indisponible ou annulé

    public function __construct(string $praticien, string $patient, string $specialite, DateTimeImmutable|false $creneau)
    {
        $this->idPraticien = $praticien;
        $this->idPatient = $patient;
        $this->specialite_label = $specialite;
        $this->creneau = $creneau;
    }

    public function toDTO(): RDVDTO
    {
        return new RDVDTO($this);
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setPatient(string $patient): void
    {
        $this->idPatient = $patient;
    }
    
    public function setSpecialite(string $specialite): void
    {
        $this->specialite_label = $specialite;
    }

    public function getSpecialite(): string
    {
        return $this->specialite_label;
    }

    public function getPatient(): string
    {
        return $this->idPatient;
    }

    public function getPraticien(): string
    {
        return $this->idPraticien;
    }

    
}