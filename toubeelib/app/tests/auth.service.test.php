<?php

// script pour tester le service d'authentification
require_once __DIR__ . '/../vendor/autoload.php';

use toubeelib\core\services\auth\AuthService;
use toubeelib\core\dto\InputAuthDTO;
use toubeelib\core\services\auth\AuthenticationException;
use toubeelib\core\services\auth\AuthProvider;
use toubeelib\infrastructure\PDO\PdoUserRepository;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;


// Configuration du conteneur de dépendances
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/dependencies.php');

$container = $containerBuilder->build();

try {
    // Récupérer l'objet PDO à partir du conteneur de dépendances
    $pdo = $container->get('auth.pdo');
    echo "Connexion à la base de données réussie.\n";

    $authService = new AuthService(new PdoUserRepository($pdo));
    $authProvider = new AuthProvider($authService);

    // Test de la fonction authenticate
    try {
        $user = $authService->authenticate(new InputAuthDTO('jmarin@riviere.com', 'jmarin'));
        print_r($user);
    } catch (AuthenticationException $e) {
        echo $e->getMessage();
    }

    //test avec invalid credentials
    try {
        $user = $authService->authenticate(new InputAuthDTO('sgodard@vasseur.com', 'incorrect'));
        print_r($user);
    } catch (AuthenticationException $e) {
        echo $e->getMessage();
    }

    //test avec authprovider
    try{
        $authToken = $authProvider->signin(new InputAuthDTO('jmarin@riviere.com', 'jmarin'));
        print_r($authToken);
    } catch (AuthenticationException $e) {
        echo $e->getMessage();
    }

} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage() . "\n";
}