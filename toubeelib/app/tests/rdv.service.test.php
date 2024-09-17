<?php
require_once __DIR__ . '/../vendor/autoload.php';

$serviceRdv = new \toubeelib\core\services\rdv\ServiceRdv(
    new \toubeelib\infrastructure\repositories\ArrayRdvRepository(),
    new \toubeelib\core\services\praticien\ServicePraticien(new \toubeelib\infrastructure\repositories\ArrayPraticienRepository())
);

// créer un rendez vous à partir d'un rendez vous existant
$rdv = $serviceRdv->getRendezVousById('r1');
$rdvDTO = $serviceRdv->creerRendezVous($rdv);
print_r($rdvDTO);

// créer un rendez vous entièrement 

$praticien = new \toubeelib\core\domain\entities\praticien\Praticien('Doc', 'teur', 'Nancy', '0123456789');
$praticien->setID('p2');
$rtest = new \toubeelib\core\domain\entities\rdv\RendezVous('p2', 'pa2', 'E', \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00') );
$rtest->setID('rtest');
$rtest->setNewPatient(true);
$rtest->setType(true);
print_r($rtest);
$rdv1 = $serviceRdv->creerRendezVous(new \toubeelib\core\dto\RendezVousDTO($rtest, new \toubeelib\core\dto\PraticienDTO($praticien)));

print_r($rdv1);

// update du type de rendez vous
$rtest->setType(false);
$rdv2 = $serviceRdv->creerRendezVous(new \toubeelib\core\dto\RendezVousDTO($rtest, new \toubeelib\core\dto\PraticienDTO($praticien)));
print_r($rdv2);


