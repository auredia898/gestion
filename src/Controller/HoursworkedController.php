<?php

namespace App\Controller;

use App\Entity\Hoursworked;
use App\Form\HoursworkedType;
use App\Repository\HoursworkedRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hoursworked')]
class HoursworkedController extends AbstractController
{
    #[Route('/', name: 'app_hoursworked_index', methods: ['GET', 'POST'])]
    public function index(Request $request, HoursworkedRepository $hoursworkedRepository, EntityManagerInterface $entityManager): Response
    {
        $hoursworked = new Hoursworked();
        $form = $this->createForm(HoursworkedType::class, $hoursworked);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hoursworked);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_hoursworked_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('hoursworked/index.html.twig', [
            'hoursworkeds' => $hoursworkedRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_hoursworked_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hoursworked = new Hoursworked();
        $form = $this->createForm(HoursworkedType::class, $hoursworked);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hoursworked);
            $entityManager->flush();

            return $this->redirectToRoute('app_hoursworked_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hoursworked/new.html.twig', [
            'hoursworked' => $hoursworked,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hoursworked_show', methods: ['GET'])]
    public function show(Hoursworked $hoursworked): Response
    {
        return $this->render('hoursworked/show.html.twig', [
            'hoursworked' => $hoursworked,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hoursworked_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hoursworked $hoursworked, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HoursworkedType::class, $hoursworked);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hoursworked_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hoursworked/edit.html.twig', [
            'hoursworked' => $hoursworked,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hoursworked_delete', methods: ['POST'])]
    public function delete(Request $request, Hoursworked $hoursworked, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hoursworked->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hoursworked);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hoursworked_index', [], Response::HTTP_SEE_OTHER);
    }
}
