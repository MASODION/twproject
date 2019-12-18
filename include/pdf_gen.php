<?php
    require('fpdf.php');
    class PDF extends FPDF
    {
        // Page header
        function Header()
        {
            // Logo
            $this->Image('dist/img/AdminLTELogo.png',73,10,15);
            // Arial bold 15
            $this->SetFont('Arial','B',25);
            // Move to the right
            $this->Cell(80);
            // Title
            $this->Cell(30,15,'MedenGen');
            // Line break
            $this->Ln(20);
        }
        
        // Page footer
        function Footer()
        {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Page number
            $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
        }
    }
?>