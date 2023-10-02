<?php
namespace App\PDF;

use FPDF;
use Knp\Snappy\Pdf as KnpSnappyPdf; // Utilisez un alias pour le service Knplabs/KnpSnappyBundle


class MissionPdf extends FPDF
{
    private $snappyPdf; // Utilisez un autre nom pour éviter le conflit

    public function __construct(KnpSnappyPdf $snappyPdf) // Utilisez le nouvel alias
    {
        $this->snappyPdf = $snappyPdf; // Utilisez le nouvel alias
    }

    public function Header()
    {
        // En-tête du PDF (facultatif)
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Facture de la mission', 0, 1, 'C');
    }

    public function Footer()
    {
        // Pied de page du PDF (facultatif)
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    public function generatePdfContent(Missions $mission)
    {
        $this->AddPage();
        $this->SetFont('Arial', '', 12);

        $this->Cell(0, 10, 'Date de la mission: ' . $mission->getStartDate()->format('d/m/Y'), 0, 1);
        $this->Cell(0, 10, 'Objectif de la mission: ' . $mission->getObjective(), 0, 1);


        // ...

        // Exemple : $this->Cell(0, 10, 'Autre détail: ' . $mission->getAutreDetail(), 0, 1);
    }

    // ...

}
?>