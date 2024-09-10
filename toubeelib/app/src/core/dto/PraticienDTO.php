<?php

namespace toubeelib\core\dto;

use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\dto\DTO;

class PraticienDTO extends DTO
{
    protected string $ID;
    protected string $nom;
    protected string $prenom;
    protected string $adresse;
    protected string $tel;
    protected string $specialite_label;

    public function __construct(Praticien $p)
    {
        $this->ID = $p->getID();
        $this->nom = $p->nom;
        $this->prenom = $p->prenom;
        $this->adresse = $p->adresse;
        $this->tel = $p->tel;
        $this->specialite_label = $p->specialite->label;
    }


}