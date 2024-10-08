<?php
namespace toubeelib\infrastructure\PDO;


use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use PDOException;
use PDO;

class PdoPraticienRepository implements RDVRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }  

    public function getRDVs(): array {
        try {
            $stmt = $this->pdo->prepare('
            SELECT r.*, p.id AS praticien_id, p.nom AS praticien_nom, p.prenom AS praticien_prenom, p.adresse AS praticien_adresse, p.telephone AS praticien_telephone
            FROM rendez_vous r
            JOIN praticien p ON r.praticien_id = p.id');
        } catch (PDOException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
    }
        }



        
    public function getRDVById(string $id): RendezVous;
    public function save(RendezVous $rdv): RDVDTO;
    public function update(RendezVous $rdv): RDVDTO;
    

}