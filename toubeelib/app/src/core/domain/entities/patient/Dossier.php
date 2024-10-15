<?php

namespace toubeelib\core\domain\entities\patient;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\DossierDTO;

class Dossier extends Entity
{

    protected string $label;
    protected string $description;

    public function __construct(string $ID, string $label, string $description)
    {
        $this->ID = $ID;
        $this->label = $label;
        $this->description = $description;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function toDTO(): DossierDTO
    {
        return new DossierDTO($this->ID, $this->label, $this->description);

    }
}