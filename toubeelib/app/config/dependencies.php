<?php

use toubeelib\core\services\rdv\ServiceRDVInterface;
use toubeelib\core\services\rdv\ServiceRDV;
use toubeelib\core\repositoryInterfaces\RDVRepositoryInterface;
use toubeelib\core\repositoryInterfaces\PraticienRepositoryInterface;
use toubeelib\infrastructure\repositories\ArrayRdvRepository;
use toubeelib\infrastructure\repositories\ArrayPraticienRepository;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Monolog\Logger;

return [

    

    // Utilisation d'une instance ArrayRdvRepository à chaque utilisation d'une RDVRepositoryInterface
    RDVRepositoryInterface::class => function () {
        return new ArrayRdvRepository();
    },

    // Utilisation d'une instance ArrayPraticienRepository à chaque utilisation d'une PraticienRepositoryInterface
    PraticienRepositoryInterface::class => function () {
        return new ArrayPraticienRepository();
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
    

];

    'praticien.pdo' => function (ContainerInterface $container) {
        $config = parse_ini_file(__DIR__ . '/praticien.db.ini');
        $dsn = "{$config['driver']}:host={$config['host']};dbname={$config['database']}";
        $user = $config['username'];
        $password = $config['password'];
        return new \PDO($dsn, $user, $password, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    },

    // Utilisation d'une instance ArrayRdvRepository à chaque utilisation d'une RDVRepositoryInterface
    RDVRepositoryInterface::class => function () {
        return new ArrayRdvRepository();
    },

    // Utilisation d'une instance ArrayPraticienRepository à chaque utilisation d'une PraticienRepositoryInterface
    PraticienRepositoryInterface::class => function () {
        return new ArrayPraticienRepository();
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
    

];
