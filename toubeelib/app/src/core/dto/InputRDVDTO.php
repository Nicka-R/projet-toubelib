<?php

namespace toubeelib\core\dto;

class InputRDVDTO extends DTO
{
    protected bool $type;
    protected string $etatConsult;
    protected bool $etatPatient; 
    protected bool $status; 
    protected string $creneau;
    protected string $praticien; // UUID du praticien
    protected string $specialite; // UUID de la spécialité


   public function _construct(bool $type, string $etatConsult, bool $etatPatient, bool $status, string $creneau, string $praticien, string $specialite) {
       $this->type = $type;
       $this->etatConsult = $etatConsult;
       $this->etatPatient = $etatPatient;
       $this->status = $status;
       $this->creneau = $creneau;
       $this->praticien = $praticien;
       $this->specialite = $specialite;
   }
}