<?php

require_once __DIR__ . '/../vendor/autoload.php';

$service = new toubeelib\core\services\patient\ServicePatient(new \toubeelib\infrastructure\repositories\ArrayPatientRepository());

$pdto = new \toubeelib\core\dto\InputPatientDTO('néplin', 'jean', 'vandeuve', '06 07 08 09 11', 'A');
$pdto2 = new \toubeelib\core\dto\InputPatientDTO('némar', 'jean', 'lassou', '06 07 08 09 12', 'B');

$pe1 = $service->createPatient($pdto);
print_r($pe1);
$pe2 = $service->createPatient($pdto2);
print_r($pe2);

$pe11 = $service->getPatientById($pe1->ID);
print_r($pe2);
$pe22 = $service->getPatientById($pe2->ID);


try {
    $pe33 = $service->getPatientById('ABCDE');
} catch (\toubeelib\core\services\patient\ServicePatientInvalidDataException $e){
    echo 'exception dans la récupération d\'un patient :' . PHP_EOL;
    echo $e->getMessage(). PHP_EOL;
}

$pdto3 = new \toubeelib\core\dto\InputPatientDTO('némar', 'jean', 'lassou', '06 07 08 09 12', 'Z');
try {
    $pe2 = $service->createPatient($pdto3);
} catch (\toubeelib\core\services\patient\ServicePatientInvalidDataException $e) {
    echo 'exception dans la création d\'un patient :' . PHP_EOL;
    echo $e->getMessage(). PHP_EOL;
}
try {
    print 'patient prédéfini p1 : ' . PHP_EOL;
    $p1 = $service->getPatientById('p1');
    print_r($p1);
} catch (\toubeelib\core\services\patient\ServicePatientInvalidDataException $e){
    echo 'exception dans la récupération d\'un patient :' . PHP_EOL;
    echo $e->getMessage(). PHP_EOL;
}

