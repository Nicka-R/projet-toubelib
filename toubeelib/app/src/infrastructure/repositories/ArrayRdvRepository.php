<?php

namespace toubeelib\infrastructure\repositories;

use Ramsey\Uuid\Uuid;
use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;

class ArrayRdvRepository implements RDVRepositoryInterface
{
    private array $rdvs = [];

    public function __construct() {
            $r1 = new RendezVous('p1', 'pa1', 'A', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00') );
            $r1->setID('r1');
            $r2 = new RendezVous('p1', 'pa1', 'A', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 10:00'));
            $r2->setID('r2');
            $r3 = new RendezVous('p2', 'pa1', 'A', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:30'));
            $r3->setID('r3');

        $this->rdvs  = ['r1'=> $r1, 'r2'=>$r2, 'r3'=> $r3 ];
    }

    public function getRendezVousById(string $id): RendezVous
    {
        if (!isset($this->rdvs[$id])) {
            throw new RepositoryEntityNotFoundException("Rendez vous introuvable");
        }
        return $this->rdvs[$id];
    }

    public function getRendezVousByPraticienAndDate(string $praticien_id, \DateTimeImmutable $date): array
    {
        $rdvs = [];
        foreach ($this->rdvs as $rdv) {
            if ($rdv->getPraticienID() === $praticien_id && $rdv->getDate() == $date) {
                $rdvs[] = $rdv;
            }
        }
        return $rdvs;
    }

    public function save(RendezVous $rdv): RendezVous
    {
        $this->rdvs[$rdv->getID()] = $rdv;
        return $rdv;
    }

    public function getRendezVousPraticien(string $praticien_id, \DateTimeImmutable $dateDebut, \DateTimeImmutable $dateFin): array
    {
        $rdvs = [];
        foreach ($this->rdvs as $rdv) {
            if ($rdv->getPraticienID() === $praticien_id && $rdv->getDate() >= $dateDebut && $rdv->getDate() <= $dateFin) {
                $rdvs[] = $rdv;
            }
        }
        return $rdvs;
    }
  
}