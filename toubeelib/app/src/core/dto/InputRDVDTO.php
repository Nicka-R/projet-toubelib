<?php

namespace toubeelib\core\dto;

class InputRDVDTO extends DTO
{
    // protected string $type;
    // protected string $etatConsult;
    // protected string $etatPatient; 
    // protected string $status; 
    
    protected string $praticien; // UUID du praticien
    protected string $patient; // UUID du patient
    protected string $specialite; // UUID de la spécialité
    protected string $creneau;


   public function _construct(string $praticien, string $patient, string $specialite,string $creneau) {
    $this->praticien = $praticien;   
    $this->patient = $patient;
    $this->specialite = $specialite;
    $this->creneau = $creneau;   
   }
}