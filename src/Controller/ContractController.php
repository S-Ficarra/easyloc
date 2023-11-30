<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Contract;
use App\Form\ContractType;

class ContractController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/contracts", name="app_contract_index", methods={"GET"})
     */
    public function index(): Response
    {
        $contracts = $this->entityManager->getRepository(Contract::class)->findAll();

        return $this->render('contract/index.html.twig', [
            'contracts' => $contracts,
        ]);
    }

    /**
     * @Route("/contracts/new", name="app_contract_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        $buttonLabel = 'Ajouter le contrat';

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contract);
            $entityManager->flush();

            
            return $this->redirectToRoute('afficher_contrat');
        }

        return $this->render('contract/new.html.twig', [
            'contract' => $contract,
            'form' => $form->createView(),
            'buttonLabel' => $buttonLabel,
        ]);
    }

    /**
     * @Route("/contracts/{id}/edit", name="app_contract_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $contractToModify = $this->entityManager->getRepository(Contract::class)->findOneBy(['id' => $id]);

        if (!$contractToModify) {
            throw $this->createNotFoundException('Contrat non trouvé');
        }

        $form = $this->createForm(ContractType::class, $contractToModify);
        $form->handleRequest($request);

        $buttonLabel = 'Modifier le contrat';

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $successMessage = 'Contrat modifié avec succès!';
            

            return $this->render('contract/edit.html.twig', [
                'form' => $form->createView(),
                'successMessage' => $successMessage,
            ]);        
        }

        return $this->render('contract/edit.html.twig', [
            'form' => $form->createView(),
            'buttonLabel' => $buttonLabel,
        ]);
    }

    /**
     * @Route("/contracts/{id}", name="app_contract_delete", methods={"DELETE"})
     */
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {

        $contractToDelete = $this->entityManager->getRepository(Contract::class)->findOneBy(['id' => $id]);


        if (!$contractToDelete) {
            throw $this->createNotFoundException('Contrat non trouvé');
        }
    
        if ($request->isMethod('POST')) {
            $entityManager->remove($contractToDelete);
            $entityManager->flush();
    
            $successMessage = 'Contrat supprimé avec succès!';
    
            return $this->redirectToRoute('afficher_contrat', [
                'successMessage' => $successMessage,
            ]);
        }
    
        return $this->render('contract/delete.html.twig', [
            'contract' => $contractToDelete,
        ]);
    }
}
