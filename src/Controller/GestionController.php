<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Knp\Snappy\Pdf;
use Knp\Snappy\Pdf as SnappyPdf; 
use App\Pdf\MissionPdf;
use App\Repository\MissionsRepository;
use App\Repository\HoursworkedRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EmployeesRepository;
use App\Repository\PositionsRepository;
use App\Entity\Missions;
use App\Entity\Employees;
use App\Entity\Positions;
use App\Entity\Hoursworked;


class GestionController extends AbstractController
{
    #[Route('/', name: 'app_gestion')]
    public function index(MissionsRepository $missionRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les missions depuis la base de données
        $missions = $missionRepository->findAll();

        $missionsData = [];
        foreach ($missions as $mission) {
            $missionId = $mission->getId();
            $missionData = [
                'mission' => $mission,
                'employees' => [],
            ];
            
            // Récupérez les heures travaillées pour cette mission
            $hoursWorked = $entityManager->createQueryBuilder()
                ->select('hw', 'e', 'p')
                ->from(Hoursworked::class, 'hw')
                ->join('hw.employee', 'e')
                ->join('e.position', 'p')
                ->where('hw.mission = :mission')
                ->setParameter('mission', $mission)
                ->getQuery()
                ->getResult();
            
            foreach ($hoursWorked as $hour) {
                $missionData['employees'][] = $hour;
            }
            
            $missionsData[] = $missionData;
        }
        

        // Passez les données à Twig pour les afficher
        return $this->render('gestion/index.html.twig', [
            'missionsData' => $missionsData,
        ]);
    }

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mission/pdf/{missionId}', name: 'mission_pdf')]
    public function generateMissionPdf(MissionPdf $missionPdf, $missionId): Response
    {
        $mission = $this->entityManager->getRepository(Missions::class)->find($missionId);
    
        if (!$mission) {
            throw $this->createNotFoundException('Mission non trouvée');
        }
    
        dd($mission);
        // Générez le contenu PDF en utilisant la méthode generatePdfContent
        $missionPdf->generatePdfContent($mission);
    
        // Sortie du PDF
        $missionPdf->Output();
    
        return new Response();
    }
      
    // private $entityManager;

    // public function __construct(EntityManagerInterface $entityManager)
    // {
    //     $this->entityManager = $entityManager;
    // }
    
    // #[Route('/mission/pdf/{missionId}', name: 'mission_pdf')]
    // public function generateMissionPdf(Request $request, Pdf $pdf, $missionId): Response
    // {
    //     // Récupérez la mission depuis le gestionnaire d'entités
    //     $mission = $this->entityManager->getRepository(Missions::class)->find($missionId);
    
    //     if (!$mission) {
    //         throw $this->createNotFoundException('Mission non trouvée');
    //     }
    
    //     // Récupérez les heures travaillées pour cette mission
    //     $hoursWorked = $this->entityManager->getRepository(Hoursworked::class)->findBy(['mission' => $mission]);
    
    //     // Générez le contenu HTML à partir du modèle Twig
    //     $html = $this->renderView('gestion/mission_pdf.html.twig', [
    //         'missionData' => ['mission' => $mission, 'employees' => $hoursWorked],
    //     ]);
    
    //     // Générez le PDF
    //     $response = new Response(
    //         $pdf->getOutputFromHtml($html),
    //         200,
    //         [
    //             'Content-Type' => 'application/pdf',
    //             'Content-Disposition' => 'inline; filename="mission.pdf"',
    //         ]
    //     );
    
    //     return $response;
    // }
    
}
