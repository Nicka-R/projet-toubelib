<?php

namespace toubeelib\core\dto;

use DateTimeImmutable;
use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\dto\DTO;

class RDVDTO extends DTO
{   
    protected string $ID;
    protected string $praticien;
    protected string $patient;
    protected string $specialite;
    protected string $creneau;
    // protected string $type;
    // protected string $etatConsult;
    // protected string $etatPatient; 
    // protected string $status; 
    // protected string $creneau;

    public function __construct(RendezVous $r)
    {
        $this->ID = $r->getID();
        $this->praticien = $r->idPraticien;
        $this->patient = $r->idPatient;
        $this->specialite = $r->specialite_label;
        $this->creneau = $r->creneau ? $r->creneau->format('Y-m-d H:i:s') : '';
        
    }

    public function getID(): string
    {
        return $this->ID;
    }

    public function getPraticien(): string
    {
        return $this->praticien;
    }

    public function getPatient(): string
    {
        return $this->patient;
    }

    public function getSpecialite(): string
    {
        return $this->specialite;
    }

    public function getCreneau(): string
    {
        return $this->creneau;
    }




}