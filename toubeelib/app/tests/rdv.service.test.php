<?php
require_once __DIR__ . '/../vendor/autoload.php';

$serviceRdv = new \toubeelib\core\services\rdv\ServiceRdv(
    new \toubeelib\infrastructure\repositories\ArrayRdvRepository(),
    new \toubeelib\core\services\praticien\ServicePraticien(new \toubeelib\infrastructure\repositories\ArrayPraticienRepository())
);


$rdv = $serviceRdv->getRendezVousById('r1');
// $speDTO = $serviceRdv->getSpecialiteById('A');
// $spe = $speDTO->toEntity();
// $rdv->setSpecialite($spe);
// print_r($rdv);

// Exemple de création d'un objet RendezVousDTO(RendezVous $rendezVous, PraticienDTO $praticien) car creerRendezVous(RendezVousDTO $rendezVousDTO)
$rdvDTO = $serviceRdv->creerRendezVous($rdv);
print_r($rdvDTO);

