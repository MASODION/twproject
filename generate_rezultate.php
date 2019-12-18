<?php

    include 'conn/config.php';
    include 'include/auth_checker.php';
    include 'include/pacient_checker.php';
    include 'include/pdf_gen.php';   


    if(isset($_GET['id'])) {
        $id_pacient = $_SESSION['userID'];
        $id = intval($_GET['id']);
        $check = $conn->prepare("SELECT a.rID, a.rProgramare, a.rResult, a.rMedicatie, a.rPret, b.pMedic, b.pConsultatie, b.pDataProgramare, b.pOraProgramare, b.ptimestamp, b.pDurata, s.userID, s.userFirstName as prenume_doctor, s.userLastName as nume_doctor, s.userPhoneNumber as numar_doctor, s.userEmail as email_doctor, s.userEmail, s.userPhoneNumber, c.cName, c.cSectie, ss.sNume, abc.userFirstName as prenume_pacient, abc.userLastName as nume_pacient, abc.userPhoneNumber as numar_pacient, abc.userEmail as email_pacient FROM rezultate a INNER JOIN programari b ON a.rProgramare = b.pID INNER JOIN users s ON b.pMedic = s.userID INNER JOIN consultatii c ON b.pConsultatie = c.cID INNER JOIN sectii ss ON c.cSectie = ss.sID INNER JOIN users abc ON b.pPacient = abc.userID WHERE a.rID = '$id' AND b.pPacient = '$id_pacient'");
        $check->execute();
        $rowcount = $check->rowCount();
        if($rowcount > 0) {
            $row = $check->fetch();
            $pdf = new PDF('P','mm','A4');
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 13);
            $pdf->Ln();
            $pdf->Cell(60, 10, 'Informatii pacient: ');
            $pdf->Cell(50);
            $pdf->Cell(30, 10, 'Informatii doctor: ');
            $pdf->Ln();
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(40,10, 'Nume: ' . $row['nume_pacient'] . ' ' . $row['prenume_pacient']);
            $pdf->Cell(70);
            $pdf->Cell(40,10, 'Nume: ' . $row['nume_doctor'] . ' ' . $row['prenume_doctor']);
            $pdf->Ln();
            $pdf->Cell(40,10, 'Telefon: ' . $row['numar_pacient']);
            $pdf->Cell(70);
            $pdf->Cell(40,10, 'Telefon: ' . $row['numar_doctor']);
            $pdf->Ln();
            $pdf->Cell(40,10, 'Email: ' . $row['email_pacient']);
            $pdf->Cell(70);
            $pdf->Cell(40,10, 'Email: ' . $row['email_doctor']);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Cell(40,10, 'Data consultului: ' . $row['pDataProgramare']. ', ora: ' . $row['pOraProgramare']);
            $pdf->Ln();
            $pdf->Cell(40,10, 'Diagnostic: ' . $row['rResult']);
            $pdf->Ln();
            $medicatie = $row['rMedicatie'];
            if(!empty($medicatie)) {
                $pdf->Cell(40,10, 'Medicatie:');
                $pdf->Ln();
                while(strpos($medicatie, ";")) {
                    $indice = strpos($medicatie, ";");
                    $pdf->Cell(40,10, '- ' . str_replace(' ', '', substr($medicatie, 0, $indice)));
                    $pdf->Ln();
                    $medicatie = substr($medicatie, $indice + 1, strlen($medicatie));
                }
                if(!empty($medicatie)) {
                    $pdf->Cell(40,10, '- ' . str_replace(' ', '', $medicatie));
                    $pdf->Ln();
                }
            }
            $pdf->Output();
        }
        else {
            header("location:home");
            exit;
        }
    }
    else {
        header("location:home");
        exit;
    }
?>