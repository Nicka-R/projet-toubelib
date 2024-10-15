<?php

namespace toubeelib\core\dto;

use toubeelib\core\dto\DTO;

use toubeelib\core\domain\entities\patient\Dossier;

class DossierDTO extends DTO
{
    protected string $ID;
    protected string $label;
    protected string $description;

    public function __construct(string $ID, string $label, string $description)
    {
        $this->ID = $ID;
        $this->label = $label;
        $this->description = $description;
    }

    public function toEntity(): Dossier
    {
        $s = new Dossier($this->ID, $this->label, $this->description);
        return $s;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}