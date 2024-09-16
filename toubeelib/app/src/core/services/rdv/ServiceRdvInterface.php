<?php
namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\RendezVousDTO;

interface ServiceRdvInterface
{
    /**
     * fonction qui affiche les détails d'un rendez-vous à l'aide de son id
     * @param id l'id du rendez vous 
     * @return le rendez vous voulu
     */
    public function getRendezVousById(string $id): RendezVousDTO;
}