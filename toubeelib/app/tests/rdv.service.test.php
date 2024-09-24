<?php
require_once __DIR__ . '/../vendor/autoload.php';

$serviceRdv = new \toubeelib\core\services\rdv\ServiceRdv(
    new \toubeelib\infrastructure\repositories\ArrayRdvRepository(),
    new \toubeelib\core\services\praticien\ServicePraticien(new \toubeelib\infrastructure\repositories\ArrayPraticienRepository())
);

//créer un rdv à aprtir d'un inputRdvDTO
try {

    // cas 1 : praticien disponible
    $inputRdv = new \toubeelib\core\dto\InputRdvDTO(
        'p1', // praticien_id
        'pa1', // patient_id
        'A', // specialite_id
        \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-10-02 09:00'), // date
        true, // newPatient
        false, // type
        false, // isConfirmed
        false, // isPaid
    );
    $rdv1 = $serviceRdv->creerRendezVous($inputRdv);
    print_r($rdv1);

    // cas 2 : praticien non disponible
    $inputRdv = new \toubeelib\core\dto\InputRdvDTO(
        'p3', // praticien_id
        'pa1', // patient_id
        'C', // specialite_id
        \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), // date
        true, // newPatient
        false, // type
        false, // isConfirmed
        false, // isPaid
    );

    $rdv2 = $serviceRdv->creerRendezVous($inputRdv);
    print_r($rdv2);
    $rdv3 = $serviceRdv->creerRendezVous($inputRdv);

    // cas 3 : praticien disponible, specialite qui ne correspond pas à celle du praticien
    $inputRdv = new \toubeelib\core\dto\InputRdvDTO(
        'p3', // praticien_id
        'pa1', // patient_id
        'A', // specialite_id qui ne correspond pas à celle du praticien
        \DateTimeImmutable::createFromFormat('Y-m-d H:i','2024-09-02 09:00'), // date
        true, // newPatient
        false, // type
        false, // isConfirmed
        false, // isPaid
    );
    $dispo = $serviceRdv->isPraticienAvailable($inputRdv->praticien_id, $inputRdv->date);
    $check = $serviceRdv->checkPraticienSpecialites($inputRdv->praticien_id, $inputRdv->specialite_id);
    $rdv1 = $serviceRdv->creerRendezVous($inputRdv);
    print_r($rdv1);



    
    
} catch (\toubeelib\core\services\rdv\ServiceRendezVousInvalidDataException $e) {
    echo $e->getMessage();
} catch (\toubeelib\core\services\praticien\ServicePraticienInvalidDataException $e) {
    echo $e->getMessage();
}
