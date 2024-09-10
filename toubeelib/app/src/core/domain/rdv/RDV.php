<?php

namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\RDVDTO;

class RDV extends Entity
{
    protected bool $type; //présentiel ou téléconsultation
    protected string $etatConsult; //réalisée, payée ou transmise aux organismes sociaux
    protected bool $etatPatient; //patient nouveau ou non
    protected bool $status; //rdv disponible ou non
    protected string $creneau;
    protected string $idPraticien;
    protected string $idSpecialite;

    public function __construct(bool $type, bool $etatPatient, string $creneau, string $idPraticien, string $idSpecialite)
    {
        $this->type = $type;
        $this->etatConsult = "non réalisée";
        $this->etatPatient = $etatPatient;
        $this->status = 0;
        $this->creneau = $creneau;
        $this->idPraticien = $idPraticien;
        $this->idSpecialite = $idSpecialite;
    }

    public function toDTO(): RDVDTO
    {
        return new RDVDTO($this);
    }
}