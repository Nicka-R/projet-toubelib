<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\services\rdv\ServiceRDVInvalidDataException;
use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\domain\entities\rdv\RDV;
use toubeelib\core\dto\RDVDTO;

class ServiceRDV extends ServiceRDVInterface {

    private RDVRepositoryInterface $rdvRepository;
    private PraticienRepositoryInterface $praticienRepository;

    public function __construct(RDVRepositoryInterface $rdvRepository, PraticienRepositoryInterface $praticienRepository) {
        $this->rdvRepository = $rdvRepository;
        $this->praticienRepository = $praticienRepository;
    } 

    public function creerRendezvous(InputRDVDTO $r): RDVDTO 
    {
        try {
            // Test Praticien existe 
            $praticien = $this->praticienRepository->getPraticienById($r->praticien);

            // Test Specialite existe
            if ($praticien->specialite->ID !== $r->specialite) {
                throw new ServiceRDVInvalidDataException('Spécialité non valide pour ce praticien');    
            } else {            
                $specialite = $this->praticienRepository->getSpecialiteById($r->specialite); 
            }

            //ToDo : valider la disponibilité du créneau

            $rdv = new RDV($r->type, $r->etatPatient, $r->creneau);
            $rdv->setPraticien($praticien);
            $rdv->setSpecialite($specialite);

            $this->rdvRepository->save($rdv);

            return new RDVDTO($rdv);

        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRDVInvalidDataException('Praticien introuvable');
        } 
    }

    
    public function getRDVById(string $id): RDVDTO
    {
        try {
            $rdv = $this->rdvRepository->getRDVById($id);
            return new RDVDTO($rdv);
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServiceRDVInvalidDataException('invalid RDV ID');
        }
    }



}