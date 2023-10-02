<?php

namespace App\Controller;

use App\Entity\Missions;
use App\Form\MissionsType;
use App\Repository\MissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/missions')]
class MissionsController extends AbstractController
{
    #[Route('/', name: 'app_missions_index', methods: ['GET', 'POST'])]
    public function index(Request $request, MissionsRepository $missionsRepository, EntityManagerInterface $entityManager): Response
    {
        $mission = new Missions();
        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('app_missions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('missions/index.html.twig', [
            'missions' => $missionsRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_missions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mission = new Missions();
        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mission);
            $entityManager->flush();

            return $this->redirectToRoute('app_missions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('missions/new.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_missions_show', methods: ['GET'])]
    public function show(Missions $mission): Response
    {
        return $this->render('missions/show.html.twig', [
            'mission' => $mission,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_missions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Missions $mission, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_missions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('missions/edit.html.twig', [
            'mission' => $mission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_missions_delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Missions $mission, EntityManagerInterface $entityManager): Response
    {
            $entityManager->remove($mission);
            $entityManager->flush();

        return $this->redirectToRoute('app_missions_index', [], Response::HTTP_SEE_OTHER);
    }
}
