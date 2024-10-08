<?php

namespace toubeelib\core\services\rdv;
use toubeelib\core\dto\RDVDTO;
use toubeelib\core\dto\InputRDVDTO;


interface ServiceRDVInterface
{   
    public function getRDVs() : array ;
    public function getRDVByID(string $id) : RDVDTO ;
    public function creerRendezvous(InputRDVDTO $r): RDVDTO ;
    public function annulerRendervous(string $id): RDVDTO ;
    public function modifierPatient(string $id, string $patient): RDVDTO ;
    public function modifierSpecialite(string $id, string $specialite): RDVDTO ;

}