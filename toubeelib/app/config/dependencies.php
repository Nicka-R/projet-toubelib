<?php

use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\core\services\rdv\ServiceRDV;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\infrastructure\PDO\PdoPraticienRepository;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use toubeelib\core\services\praticien\ServicePraticien;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\auth\AuthService;
use toubeelib\core\services\auth\AuthServiceInterface;
use toubeelib\core\services\auth\AuthProvider;
use toubeelib\infrastructure\PDO\PdoUserRepository;
use app\middlewares\Cors;
use Slim\App;

return [

    'praticien.pdo' => function (ContainerInterface $container) {
        $config = parse_ini_file(__DIR__ . '/praticien.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },

    'auth.pdo' => function (ContainerInterface $container) {
        $config = parse_ini_file(__DIR__ . '/auth.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },

    PraticienRepositoryInterface::class => function (ContainerInterface $container) {
        $pdo = $container->get('praticien.pdo');
        return new PdoPraticienRepository($pdo);
    },
    
    LoggerInterface::class => function () {
        $logger = new Logger('toubeelib');
        $logfile = __DIR__ . '/../logs/toubeelib.log';
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($logfile, Logger::DEBUG));
        $logger->info('Logger initialisé');
        return $logger;
    },    

    // Utilisation d'une instance ServiceRDV à chaque utilisation d'une ServiceRDVInterface
    ServiceRDVInterface::class => function (ContainerInterface $container) {
        $rdvRepository = $container->get(RDVRepositoryInterface::class);
        $praticienRepository = $container->get(PraticienRepositoryInterface::class);
        $logger = $container->get(LoggerInterface::class);
        return new ServiceRDV($rdvRepository, $praticienRepository,$logger);
    }, 

    // Utilisation d'une instance ServicePraticien à chaque utilisation d'une ServicePraticienInterface
    ServicePraticienInterface::class => function (ContainerInterface $container) {
        $praticienRepository = $container->get(PraticienRepositoryInterface::class);
        return new ServicePraticien($praticienRepository);
    },

    UserRepositoryInterface::class => function (ContainerInterface $container) {
        $pdo = $container->get('auth.pdo');
        return new PdoUserRepository($pdo);
    },

    AuthServiceInterface::class => function (ContainerInterface $container) {
        $userRepository = $container->get(UserRepositoryInterface::class);
        return new AuthService($userRepository);
    },

    AuthService::class => function (ContainerInterface $container) {
        $userRepository = $container->get(UserRepositoryInterface::class);
        return new AuthService($userRepository);
    },

    AuthProvider::class => function (ContainerInterface $container) {
        $authService = $container->get(AuthService::class);
        return new AuthProvider($authService);
    },
    
    // enregistrement du middleware CORS
    Cors::class => function (ContainerInterface $container) {
        return new Cors();
    },

];
