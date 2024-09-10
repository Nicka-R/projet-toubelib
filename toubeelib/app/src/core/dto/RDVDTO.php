<?php

namespace toubeelib\core\dto;

use toubeelib\core\domain\entities\rdv\RDV;
use toubeelib\core\dto\DTO;

class RDVDTO extends DTO
{   
    protected string $ID;
    protected bool $type;
    protected string $etatConsult;
    protected bool $etatPatient; 
    protected bool $status; 
    protected string $creneau;
    protected string $praticien;
    protected string $specialite;

    public function __construct(RDV $r)
    {
        $this->ID = $r->getID();
        $this->type = $r->type;
        $this->etatConsult= $r->etatConsult;
        $this->etatPatient = $r->etatPatient;
        $this->status = $r->status;
        $this->creneau = $r->creneau;
        $this->praticien = $r->idPraticien;
        $this->specialite = $r->idSpecialite;
    }


}