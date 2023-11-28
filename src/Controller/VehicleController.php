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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


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

    /**
     * @Route("/rechercher-vehicule", name="rechercher_vehicule")
     */
    public function rechercherVehicule(Request $request): Response 
    {
        // Récupére les paramètres de recherche depuis la requête
        $searchId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
        $searchLicencePlate = filter_input(INPUT_GET, 'licence_plate', FILTER_SANITIZE_STRING);
        $searchKmValue = filter_input(INPUT_GET, 'km_value', FILTER_SANITIZE_NUMBER_INT);
        $moreLess = $request->query->get('km');
    
        // Initialise une variable pour stocker les résultats de la recherche
        $results = [];
    
        // Effectue la recherche en fonction des paramètres fournis
        if ($searchId) {
            // Recherche par ID
            $vehicle = $this->dm->getRepository(VehicleDocument::class)->find($searchId);
    
            if ($vehicle) {
                $results[] = $vehicle;
            }
        } elseif ($searchLicencePlate) {
            // Recherche par plaque d'immatriculation
            $vehicle = $this->dm->getRepository(VehicleDocument::class)->findOneBy(['licencePlate' => $searchLicencePlate]);
    
            if ($vehicle) {
                $results[] = $vehicle;
            }
        } elseif ($searchKmValue && ($moreLess === 'plus' || $moreLess === 'moins')) {
            $moreLessValue = ($moreLess === 'plus') ? '$gte' : '$lte';
            $criteria = ['km' => [$moreLessValue => (int)$searchKmValue]];
            $results = $this->dm->getRepository(VehicleDocument::class)->findBy($criteria);

        } else {
            // Si aucun paramètre spécifié, affiche tous les véhicules
            $results = $this->dm->getRepository(VehicleDocument::class)->findAll();
        }
    
        // Effectue le rendu de la vue en lui transmettant les résultats de la recherche
        return $this->render('rechercher_vehicule.html.twig', [
            'results' => $results,
        ]);
    } 

    /**
     * @Route("/modifier-vehicule", name="modifier_vehicule")
     */
    public function modifierVehicule (Request $request, $licencePlate) : Response
    {
        $vehicleToModify = $this->dm->getRepository(VehicleDocument::class)->findOneBy(['licencePlate' => $licencePlate]);

        if (!$vehicleToModify) {
            throw $this->createNotFoundException('Véhicule non trouvé');
        }
        
        $form = $this->createForm(VehicleType::class, $vehicleToModify)
            ->add('modifier', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dm->flush();

            $successMessage = 'Véhicule modifié avec succès!';

            // Redirigez l'utilisateur vers la page de recherche avec un message de succès
            return $this->render('modifier_vehicule.html.twig', [
                'form' => $form->createView(),
                'successMessage' => $successMessage,
            ]);
        }

        return $this->render('modifier_vehicule.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supprimer-vehicule", name="supprimer_vehicule")
     */
    public function supprimerVehicule (Request $request, $licencePlate) : Response 
    {
        $vehicleToDelete = $this->dm->getRepository(VehicleDocument::class)->findOneBy(['licencePlate' => $licencePlate]);

        if ($request->isMethod('POST')) {
            $this->dm->remove($vehicleToDelete);
            $this->dm->flush();

            $successMessage = 'Véhicule supprimé avec succès!';

            return $this->render('supprimer_vehicule.html.twig', [
                'successMessage' => $successMessage,
            ]);
        }

        return $this->render('supprimer_vehicule.html.twig', [
            'vehicleToDelete' => $vehicleToDelete,
        ]);

    }    


}
