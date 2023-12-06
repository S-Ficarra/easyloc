<?php

// src/Command/AddVehicleCommand.php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use App\Document\VehicleDocument;

class AddVehicleCommand extends Command
{
    protected static $defaultName = 'app:add-vehicle';

    private $documentManager;

    public function __construct(\Doctrine\ODM\MongoDB\DocumentManager $documentManager)
    {
        parent::__construct();
        $this->documentManager = $documentManager;
    }

    protected function configure()
    {
        $this->setDescription('Ajouter un nouveau véhicule.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        // Poser des questions interactives pour obtenir les détails du véhicule
        $licencePlate = $helper->ask($input, $output, new Question('Plaque d\'immatriculation : '));
        $informations = $helper->ask($input, $output, new Question('Informations sur le véhicule : '));
        $km = $helper->ask($input, $output, new Question('Kilométrage : '));

        // Créer un nouveau véhicule document
        $vehicle = new VehicleDocument();
        $vehicle->setLicencePlate($licencePlate);
        $vehicle->setInformations($informations);
        $vehicle->setKm($km);

        // Ajouter le véhicule à MongoDB
        $this->documentManager->persist($vehicle);
        $this->documentManager->flush();

        $output->writeln('Véhicule ajouté avec succès.');

        return Command::SUCCESS;
    }
}
