<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\dto\RDVDTO;

class RDV extends Entity
{
    protected bool $type; //présentiel ou téléconsultation
    protected string $etatConsult; //réalisée, payée ou transmise aux organismes sociaux
    protected bool $etatPatient; //patient nouveau ou non
    protected bool $status; //rdv disponible ou non
    protected string $creneau;
    protected ?Praticien $praticien;
    protected ?Specialite $specialite;

    public function __construct(bool $type, bool $etatPatient, string $creneau)
    {
        $this->type = $type;
        $this->etatConsult = "non réalisée";
        $this->etatPatient = $etatPatient;
        $this->status = 0;
        $this->creneau = $creneau;
    }

    public function setPraticien(Praticien $praticien): void
    {
        $this->praticien = $praticien;
    }

    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite;
    }

    public function toDTO(): RDVDTO
    {
        return new RDVDTO($this);
    }
}