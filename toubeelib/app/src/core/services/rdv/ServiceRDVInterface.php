<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\dto\RendezVousDTO;
use toubeelib\core\dto\InputRdvDTO;
use toubeelib\core\dto\SpecialiteDTO;

interface ServiceRdvInterface
{   
    public function getRDVs() : array ;
    public function getRendezVousById(string $id): RendezVousDTO;
    public function creerRendezVous(InputRdvDTO $inputRDV): RendezVousDTO;
    public function getSpecialiteById(string $id): SpecialiteDTO;
    public function isPraticienAvailable(string $praticien_id, \DateTimeImmutable $date): bool;
    public function checkPraticienSpecialites(string $praticienId, string $specialite): bool;
    public function listerDisposPraticien($praticien_id, \DateTimeImmutable $from, \DateTimeImmutable $to);
    public function listerRendezVousPraticien(string $praticien_id, \DateTimeInterface $dateDebut, int $nbJours): array;
    public function modifierRDV(string $rdvID, string $speID = null, string $patientID = null) :  RendezVousDTO;
}