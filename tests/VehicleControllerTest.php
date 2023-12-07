<?php 

// tests/VehicleControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VehicleControllerTest extends WebTestCase
{
    public function testAddVehicleFormValidation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ajouter-vehicule');

        $form = $crawler->selectButton('Valider')->form();

        // Ajoutez ici les données que vous souhaitez tester
        $form['vehicle[licencePlate]'] = 'AA123AA';
        $form['vehicle[informations]'] = 'Informations sur le véhicule';
        $form['vehicle[km]'] = 50000;

        $client->submit($form);

        // Vérifiez que la réponse contient un message de succès
        $this->assertSelectorTextContains('.alert-success', 'ajouté');
    }
}
