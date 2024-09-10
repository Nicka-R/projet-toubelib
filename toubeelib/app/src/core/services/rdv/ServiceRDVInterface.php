<?php

namespace toubeelib\core\services\rdv;
use toubeelib\core\dto\RDVDTO;


interface ServiceRDVInterface
{
    public function getRDVByID(string $id) : RDVDTO ;

}