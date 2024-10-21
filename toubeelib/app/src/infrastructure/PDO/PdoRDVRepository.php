<?php
namespace toubeelib\infrastructure\PDO;


use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use PDOException;
use PDO;
use toubeelib\core\domain\entities\rdv\RendezVous;
use toubeelib\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use toubeelib\core\dto\RDVDTO;

class PdoRDVRepository implements RDVRepositoryInterface
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
            FROM rdv r
            JOIN praticien p ON r.praticien_id = p.id');
            $stmt->execute();
            $rdvs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rdvs[] = new RDVDTO($row);
            }
            return $rdvs;
        } catch (PDOException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
    }
        }

        public function save(RendezVous $rdv): RDVDTO {
            try {
                $formattedDate = $rdv->getDate()->format('Y-m-d H:i:s');
                
                $stmt = $this->pdo->prepare('INSERT INTO rdv (id, date_heure, praticien_id, patient_id) VALUES (:id, :date, :praticien_id, :patient_id)');
                $stmt->execute([
                    'id' => $rdv->getID(),
                    'date' => $formattedDate,
                    'praticien_id' => $rdv->getPraticienID(),
                    'patient_id' => $rdv->getPatientID()
                ]);
                
                return new RDVDTO($rdv);
            } catch (PDOException $e) {
                throw new RepositoryEntityNotFoundException($e->getMessage());
            }
        }        
    
    public function getRendezVousByPraticienAndDate(string $praticien_id, \DateTimeImmutable $date): array {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM rdv WHERE praticien_id = :praticien_id AND date_heure = :date');
            $stmt->execute([
                'praticien_id' => $praticien_id,
                'date' => $date->format('Y-m-d')
            ]);
            $rdvs = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rdvs[] = new RDVDTO($row);
            }
            return $rdvs;
        } catch (PDOException $e) {
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }
}