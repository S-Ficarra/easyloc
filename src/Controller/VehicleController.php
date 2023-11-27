<?php

// src/Controller/VehicleController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\VehicleDocument; 
use App\Form\VehicleType;

class VehicleController extends AbstractController
{

    // Injecte DocumentManager qui permet d'intéragir avec la BDD
    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    /**
     * @Route("/ajouter-vehicule", name="ajouter_vehicule")
     */
    public function ajouterVehicule(Request $request): Response
    {
        // Créer une nouvelle instance de véhicule et le formulaire contenant toutes ses propriétées
        $vehicle = new VehicleDocument();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);


        // Envoi les données à la BDD si le form est validé et submit
        if ($form->isSubmitted() && $form->isValid()) {
            $this->dm->persist($vehicle);
            $this->dm->flush();

            // Récupere l'ID et la plaque d'immatriculation après l'ajout
            $vehicleId = $vehicle->getId();
            $licencePlate = $vehicle->getLicencePlate();

            // Construit le message de succès
            $successMessage = "Véhicule $licencePlate ajouté, son ID unique est : $vehicleId";


            // Effectue le rendu de la vue en lui transmettant les informations dynamique qui seront utilisées dans la vue
            return $this->render('ajouter_vehicule.html.twig', [
                'form' => $form->createView(),
                'successMessage' => $successMessage,
            ]);
           }
            
        // Effectue le rendue quand le controleur est appelé
        return $this->render('ajouter_vehicule.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
