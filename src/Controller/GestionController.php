<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request; 
use Knp\Snappy\Pdf;
use Knp\Snappy\Pdf as SnappyPdf; 
use Dompdf\Dompdf;
use Dompdf\Options;
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
        $missions = $missionRepository->findAll();
        $missionsData = [];
        foreach ($missions as $mission) {
            $missionId = $mission->getId();
            $missionData = [
                'mission' => $mission,
                'employees' => [],
            ];
            
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
    public function generateMissionPdf(Request $request, $missionId): Response
    {
        $mission = $this->entityManager->getRepository(Missions::class)->find($missionId);

        if (!$mission) {
            throw $this->createNotFoundException('Mission non trouvée');
        }

        $hoursWorked = $this->entityManager->getRepository(Hoursworked::class)->findBy(['mission' => $mission]);

        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);

        $html = $this->renderView('gestion/mission_pdf.html.twig', [
            'mission' => $mission,
            'employees' => $hoursWorked, // Passez également les employés au modèle Twig
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="mission.pdf"');

        return $response;
    }


    #[Route('/employee/pdf/{employeeId}/{missionId}', name: 'generate_employee_pdf')]
    public function generateEmployeePdf(Request $request, $employeeId, $missionId): Response
    {
        $employee = $this->entityManager->getRepository(Employees::class)->find($employeeId);
        $mission = $this->entityManager->getRepository(Missions::class)->find($missionId);

        if (!$employee || !$mission) {
            throw $this->createNotFoundException('Employé ou mission non trouvée');
        }

        $totalAmount = 0;
        foreach ($employee->getHoursworkeds() as $hoursWorked) {
            $totalAmount += $hoursWorked->getNumberHours() * $hoursWorked->getEmployee()->getPosition()->getHourlyRate();
        }

        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);

        $html = $this->renderView('gestion/employee_pdf.html.twig', [
            'employee' => $employee,
            'mission' => $mission,
            'totalAmount' => $totalAmount, 
        ]);

        $dompdf->loadHtml($html);
        $dompdf->render();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="employee_invoice.pdf"');

        return $response;
    }

}
