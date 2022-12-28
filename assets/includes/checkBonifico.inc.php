<?php
session_start();
require "../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["sendBonifico"])) {
    $idConto =  $_SESSION["ContoID"];
    $emailConto = $_SESSION["Email"];
    $ibanBeneficiario = $_POST["iban"];
    $causale = $_SESSION["causale"] = $_POST["causale"];
    $importo = floatval(implode(".", explode(",", $_POST["importo"])));
    $dataAccredito = $_SESSION["dataAccredito"] = $_POST["dataAccredito"];
    require "./dbconn.inc.php";
    $conn = openCon();

    // validazioni
    if(empty($ibanBeneficiario) || empty($importo) || empty($dataAccredito) || empty($causale)) {
        header("location: ../../bonifici.php?error=empty%input");
        exit();
    }

    // come prima cosa recuperiamo il saldo attuale del cliente mittente
    $sql = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = $idConto ORDER BY Data DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $result = mysqli_fetch_assoc($query);
        $saldoAttuale = round($result["Saldo"], 2);

        // controllo che l'importo non superi il saldo attuale
        $saldoPreventivo = round(($saldoAttuale - $importo), 2);

        if ($saldoPreventivo > 0) {
            // aggiungo la transizione ma con stato provvisorio
            $stato = "Non confermato";
            $tipo = 3;
            $sql2 = "INSERT INTO TMovimentiConto (`ContoCorrenteID`, `Data`, `Importo`, `Saldo`, `CategoriaMovimentoID`, `DescrizioneEstesa`, `Stato`)
                     VALUES (?, ?, ?, ?, ?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql2);
            mysqli_stmt_bind_param($stmt, "isddiss", $idConto, $dataAccredito, $importo, $saldoPreventivo, $tipo, $causale, $stato);
            if (mysqli_stmt_execute($stmt)) {
                // creo codice
                $security = random_int(10000, 999999);

                // mando email per confermare il giroconto
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'email';
                $mail->Password = 'password';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom("email", "Codice sicurezza banca");
                $mail->addAddress($emailConto, $_SESSION["NomeTitolare"]);

                $mail->Subject = "Codice di conferma";
                $mail->Body = "Codice di conferma: $security";

                if ($mail->send()) {
                    // una volta spedita l'email aggiungo il codice nella TLogin per effettuare la verifica in seconda fase
                    $sql3 = "INSERT INTO TLogin (ContoCorrenteID, CodiceSicurezza) VALUES (?, ?);";
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql3);
                    mysqli_stmt_bind_param($stmt, "ii", $idConto, $security);
                    if (mysqli_stmt_execute($stmt)) {
                        $_SESSION["ibanBeneficiario"] = $ibanBeneficiario;
                        header("location: ../../riepilogoBonifico.php");
                        exit();
                    } else {
                        header("location: ../../error-404.html");
                        exit();
                    }
                }
            }
        }
    }
} else {
    header("location: ../../error-404.html");
    exit();
}
