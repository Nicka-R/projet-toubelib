<?php
namespace toubeelib\core\dto;
use toubeelib\core\domain\entities\patient\Patient;
use toubeelib\core\dto\DTO;

class PatientDTO extends DTO
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;

    public function __construct(Patient $p)
    {
        $this->ID = $p->getID();
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        $this->adresse = $p->adresse;
        $this->tel = $p->tel;
    }

    public function toEntity(): Patient
    {
        $p = new Patient($this->nom, $this->prenom, $this->adresse, $this->tel);
        $p->setID($this->ID);
        return $p;
    }

    public function getID(): string
    {
        return $this->ID;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function getTel(): string
    {
        return $this->tel;
    }
}