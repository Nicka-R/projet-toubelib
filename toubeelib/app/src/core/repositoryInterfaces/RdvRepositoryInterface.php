<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\dto\RDVDTO;

interface RDVRepositoryInterface
{
    public function getRDVs(): array;
    public function getRDVById(string $id): RendezVous;
    public function save(RendezVous $rdv): RDVDTO;
    public function update(RendezVous $rdv): RDVDTO;

}