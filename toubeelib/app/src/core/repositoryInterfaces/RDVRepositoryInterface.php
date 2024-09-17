<?php

namespace toubeelib\core\repositoryInterfaces;

use toubeelib\core\domain\entities\rdv\RDV;

interface RDVRepositoryInterface
{

    public function getRDVById(string $id): RDV;
    public function save(RDV $rdv): string;

}