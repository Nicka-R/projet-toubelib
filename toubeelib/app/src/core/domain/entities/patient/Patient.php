<?php

namespace toubeelib\core\domain\entities\patient;

use toubeelib\core\domain\entities\Entity;
use toubeelib\core\dto\PatientDTO;

class Patient extends Entity
{
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    
    public function __construct(string $nom, string $prenom, string $adresse, string $tel)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresse = $adresse;
        $this->tel = $tel;
    }


    public function toDTO(): PatientDTO
    {
        return new PatientDTO($this);
    }
}