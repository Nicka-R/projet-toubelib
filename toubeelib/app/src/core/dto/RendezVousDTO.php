<?php
namespace toubeelib\core\dto;

use toubeelib\core\domain\entities\rdv\RendezVous;

class RendezVousDTO extends DTO
{
    public string $id;
    public string $praticienId;
    public \DateTimeImmutable $dateTime;
    public PraticienDTO $praticien;

    public function __construct(RendezVous $rendezVous, PraticienDTO $praticien)
    {
        $this->id = $rendezVous->getId();
        $this->praticienId = $rendezVous->getPraticienId();
        $this->dateTime = $rendezVous->getDateTime();
        $this->praticien = $praticien;
    }
}