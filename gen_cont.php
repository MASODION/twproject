<?php

    include 'conn/config.php';
    include 'include/auth_checker.php';
    include 'include/secretara_checker.php';
    include 'include/pdf_gen.php';   
    
    if(isset($_POST['doctor']) && (isset($_POST['luna']) || isset($_POST['an']))) {
        $doctor = htmlentities($_POST['doctor']);
        $punct = strpos($doctor, '.');
        $id_doctor = intval(substr($doctor, 0, $punct));
        $nume_doctor = substr($doctor, $punct + 2, strlen($doctor));
        $luna = htmlentities($_POST['luna']);
        $punct = strpos($luna, '.');
        $id_luna = substr($luna, 0, $punct);
        $luna = substr($luna, $punct+1, strlen($luna));
        $an = htmlentities($_POST['an']);
        if(empty($doctor)) {
            header("location:contabilitate");
            exit;
        }
        elseif(!empty($luna)) {
            $check = $conn->prepare("SELECT EXTRACT(MONTH FROM a.ftimestamp) as luna, EXTRACT(YEAR FROM a.ftimestamp) as an, a.fProgramareID, a.fPret, b.pMedic, b.pConsultatie, b.pDataProgramare, b.pOraProgramare, s.cName, s.cTip FROM financiar_log a INNER JOIN programari b ON a.fProgramareID = b.pID INNER JOIN consultatii s ON b.pConsultatie = s.cID WHERE b.pMedic = '$id_doctor' AND EXTRACT(MONTH FROM a.ftimestamp) = '$id_luna' ORDER BY a.ftimestamp DESC");
            $check->execute();
            $countlog = $check->rowCount();
            if($countlog > 0) {
                $row = $check->fetch();
                while($row != NULL) {
                    $array[] = $row;
                    $row = $check->fetch();
                }
            }
            $pdf = new PDF('P','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 13);
            $pdf->Ln();
            $pdf->Cell(60, 10, 'Contabilitate pentru doctorul ' . $nume_doctor . ', pentru luna: ' . $luna);
            $pdf->Ln();
            if(isset($array)) {
                $total = 0;
                foreach($array as $a){
                    $total = $total + intval($a['fPret']);
                    $pdf->Cell(60, 10, '- ' . $a['pDataProgramare'] . ' -> ' . $a['fPret']);
                    $pdf->Ln();
                }
                $pdf->Cell(60, 10, '--------------------------------------------------------------');
                $pdf->Ln();
                $pdf->Cell(60, 10, 'Total: ' . $total. ' lei.');
                $pdf->Ln();
            }
            else {
                $pdf->Cell(60, 10, 'Nu exista date.');
                $pdf->Ln();
            }
            $pdf->Output();
        }
        elseif(!empty($an)) {
            $check = $conn->prepare("SELECT EXTRACT(MONTH FROM a.ftimestamp) as luna, EXTRACT(YEAR FROM a.ftimestamp) as an, a.fProgramareID, a.fPret, b.pMedic, b.pConsultatie, b.pDataProgramare, b.pOraProgramare, s.cName, s.cTip FROM financiar_log a INNER JOIN programari b ON a.fProgramareID = b.pID INNER JOIN consultatii s ON b.pConsultatie = s.cID WHERE b.pMedic = '$id_doctor' AND EXTRACT(YEAR FROM a.ftimestamp) = '$an' ORDER BY a.ftimestamp DESC");
            $check->execute();
            $countlog = $check->rowCount();
            if($countlog > 0) {
                $row = $check->fetch();
                while($row != NULL) {
                    $array[] = $row;
                    $row = $check->fetch();
                }
            }
            $pdf = new PDF('P','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 13);
            $pdf->Ln();
            $pdf->Cell(60, 10, 'Contabilitate pentru doctorul ' . $nume_doctor . ', pentru anul: ' . $an);
            $pdf->Ln();
            if(isset($array)) {
                $total = 0;
                foreach($array as $a){
                    $total = $total + intval($a['fPret']);
                    $pdf->Cell(60, 10, '- ' . $a['pDataProgramare'] . ' -> ' . $a['fPret']);
                    $pdf->Ln();
                }
                $pdf->Cell(60, 10, '--------------------------------------------------------------');
                $pdf->Ln();
                $pdf->Cell(60, 10, 'Total: ' . $total. ' lei.');
                $pdf->Ln();
            }
            else {
                $pdf->Cell(60, 10, 'Nu exista date.');
                $pdf->Ln();
            }
            $pdf->Output();
        }
    }
    else {
        header("location:contabilitate");
        exit;
    }

?>