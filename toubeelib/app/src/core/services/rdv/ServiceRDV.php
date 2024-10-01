<?php

namespace toubeelib\core\services\rdv;

use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\services\rdv\ServiceRDVInvalidDataException;
use toubeelib\core\services\rdv\ServiceRDVNotFoundException;
use toubeelib\core\dto\InputRDVDTO;
use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\dto\RDVDTO;
use Psr\Log\LoggerInterface;

class ServiceRDV implements ServiceRDVInterface {

    private RDVRepositoryInterface $rdvRepository;
    private PraticienRepositoryInterface $praticienRepository;
    private LoggerInterface $logger;

    public function __construct(RDVRepositoryInterface $rdvRepository, PraticienRepositoryInterface $praticienRepository, LoggerInterface $logger) {
        $this->rdvRepository = $rdvRepository;
        $this->praticienRepository = $praticienRepository;
        $this->logger = $logger;
    } 

    public function getRDVs(): array
    {
        return array_map(fn(RendezVous $rdv) => new RDVDTO($rdv), $this->rdvRepository->getRDVs());
    }

    public function getRDVById(string $id): RDVDTO
    {
        try {
            $rdv = $this->rdvRepository->getRDVById($id);
            return $rdv->toDTO();
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServiceRDVInvalidDataException('ID du RDV non trouvé');
        }
    }

    public function creerRendezvous(InputRDVDTO $r): RDVDTO 
    {
        try {
            // Test Praticien existe 
            $praticien = $this->praticienRepository->getPraticienById($r->praticien); //lance une RepositoryEntityNotFoundException si le praticien n'existe pas

            // Test Specialite existe
            if ($praticien->specialite->ID !== $r->specialite) {
                throw new ServiceRDVInvalidDataException('Spécialité non valide pour ce praticien');    
            }

            //ToDo : valider la disponibilité du créneau

            $rdv = new RendezVous($r->praticien, $r->patient, $r->specialite, $r->creneau);

            $this->rdvRepository->save($rdv);

            $this->logger->info("Création du RDV avec l'ID: {$rdv->getID()}");

            return $rdv->toDTO();
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRDVInvalidDataException('Praticien introuvable');
        } 
    }  
    

    public function annulerRendervous(string $id) : RDVDTO {
        try {
            $rdv = $this->rdvRepository->getRDVById($id);
            $rdv->setStatus("annulé");

            //Todo : rendre dispo le creneau

            $this->rdvRepository->update($rdv);

            $this->logger->info("Annulation du RDV avec l'ID: {$id}");
            
            return $rdv->toDTO();
        } catch(RepositoryEntityNotFoundException $e) {
            throw new ServiceRDVInvalidDataException('ID du RDV non trouvé');
        }

    }

    public function modifierPatient(string $id, string $patient): RDVDTO {
        try {
            $rdv = $this->rdvRepository->getRDVById($id);
            $oldPatient = $rdv->getPatient();

            $rdv->setPatient($patient);

            $this->logger->info("Avant modification - Patient actuel: {$oldPatient}, ID RDV: {$id}");
            
            
            $this->rdvRepository->update($rdv);

            $newPatient = $rdv->getPatient();

            $this->logger->info("Après modification - Nouveau pa: {$newPatient}, ID RDV: {$id}");
    
            return $rdv->toDTO();
        } catch (RepositoryEntityNotFoundException $e) {
            $this->logger->error("RDV non trouvé pour l'ID: {$id}");
            throw new ServiceRDVNotFoundException('ID du RDV non trouvé');
        }
    }
    
    public function modifierSpecialite(string $id, string $specialite): RDVDTO {
        try {
            $rdv = $this->rdvRepository->getRDVById($id);
    
            $praticien = $this->praticienRepository->getPraticienById($rdv->getPraticien());

            if ($praticien->specialite->ID !== $specialite) {
                throw new ServiceRDVInvalidDataException("La spécialité {$specialite} n'est pas valide pour le praticien {$rdv->getPraticien()}.");
            }

            $oldSpecialty = $rdv->getSpecialite();
            $rdv->setSpecialite($specialite);

            $this->rdvRepository->update($rdv);

            $this->logger->info("Changement de la spécialité {$oldSpecialty} en {$specialite} pour l'ID: {$id}");
    
            return $rdv->toDTO();
        } catch (RepositoryEntityNotFoundException $e) {
            throw new ServiceRDVNotFoundException('ID du RDV non trouvé');
        }
    }
    
    



}