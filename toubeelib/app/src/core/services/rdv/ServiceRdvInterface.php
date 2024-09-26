<?php
namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\RendezVousDTO;
use toubeelib\core\dto\InputRdvDTO;
use toubeelib\core\dto\SpecialiteDTO;

interface ServiceRdvInterface
{
    /**
     * fonction qui affiche les détails d'un rendez-vous à l'aide de son id
     * @param id l'id du rendez vous 
     * @return le rendez vous voulu
     */
    public function getRendezVousById(string $id): RendezVousDTO;
    public function creerRendezVous(InputRdvDTO $inputRDV): RendezVousDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;
    public function isPraticienAvailable(string $praticien_id, \DateTimeImmutable $date): bool;
    public function checkPraticienSpecialites(string $praticienId, string $specialite): bool;
}