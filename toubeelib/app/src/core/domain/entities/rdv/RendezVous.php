<?php
namespace toubeelib\core\domain\entities\rdv;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\domain\entities\praticien\Specialite;

class RendezVous extends Entity
{
    protected string $praticienID;
    protected string $patientID;
    protected \DateTimeImmutable $date; 
    protected bool $type; // true pour les téléconsultations, false pour le présentiel
    protected bool $newPatient; // true si le patient est nouveau, false sinon
    protected string $status; // OK si le patient a honoré le rendez-vous, KO si ce n'est pas le cas, EN ATTENTE si le rendez-vous n'a pas encore eu lieu
    protected string $specialiteID;
    protected ?Specialite $specialite = null;

    public function __construct(string $praticien, string $patient, string $specialiteID, \DateTimeImmutable $date) // bool $type, bool $newPatient)
    {
        $this->praticienID = $praticien;
        $this->patientID = $patient;
        $this->specialiteID = $specialiteID;
        $this->date = $date;
        // $this->type = $type; 
        // $this->newPatient = $newPatient;
        $this->status = 'EN ATTENTE';
    }

    public function setSpecialite(Specialite $specialite): void
    {
        $this->specialite = $specialite; 
    }

    public function setNewPatient(bool $newPatient): void
    {
        $this->newPatient = $newPatient;
    }

    public function setType(bool $type): void
    {
        $this->type = $type;
    }

    /*
     * Getters et setters
     */
    public function getPraticienID(): string
    {
        return $this->praticienID;
    }

    public function getPatientID(): string
    {
        return $this->patientID;
    }

    public function getSpecialiteID(): string
    {
        return $this->specialiteID;
    }

    public function getSpecialite(): ?Specialite
    {
        return $this->specialite;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}