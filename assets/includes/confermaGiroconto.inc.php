<?php

if (isset($_POST["conferma"])) {
    session_start();
    require "./dbconn.inc.php";

    $conn = openCon();
    $idConto = $_SESSION["ContoID"];
    $ibanBeneficiario = $_SESSION["ibanBeneficiario"];
    $causale = $_SESSION["causale"];
    $importo = $_SESSION["importo"];
    $codice = $_POST["codice"]; // codice conferma

    // controllo che vengano inseriti tutti i parametri per il login
    if (empty($codice)) {
        header("location: ../../riepilogoGiroconto.php?error=empty%input");
        exit();
    }

    // controllo che il codice sia effettivamente un codice numerico
    if (!is_numeric($codice)) {
        header("location: ../../riepilogoGiroconto.php?error=invalid%code");
        exit();
    }

    $sql = "SELECT * FROM TLogin WHERE ContoCorrenteID = $idConto AND CodiceSicurezza = '$codice'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) === 1) {
        // cambio lo stato del giroconto
        $sql2 = "UPDATE TMovimentiConto SET Stato = 'Eseguito' WHERE ContoCorrenteID = $idConto";
        if (mysqli_query($conn, $sql2)) {
            // prendo il contocorrente id del beneficiario
            $sql3 = "SELECT * FROM TContiCorrenti WHERE IBAN = '$ibanBeneficiario'";
            $query3 = mysqli_query($conn, $sql3);

            if (mysqli_num_rows($query3) === 1) {
                $result3 = mysqli_fetch_assoc($query3);
                $idBeneficiario = $result3["ContoCorrenteID"];

                // poi prendo l'ultimo saldo del beneficiario
                $sql4 = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = $idBeneficiario ORDER BY Data DESC LIMIT 1";
                $query4 = mysqli_query($conn, $sql4);
                if ($query4) {
                    $result4 = mysqli_fetch_assoc($query4);
                    $saldoBeneficiarioAttuale = $result4["Saldo"];
                    // e, infine, aggiungo il movimento per il beneficiario
                    $sql5 = "INSERT INTO TMovimentiConto (ContoCorrenteID, Importo, Saldo, CategoriaMovimentoID, DescrizioneEstesa, Stato)
                            VALUES (?, ?, ?, ?, ?, ?);";
                    $categoria = 10;
                    $saldoBeneficiarioEffettivo = $importo + $saldoBeneficiarioAttuale;
                    $stato = "Eseguito";
                    $stmt = mysqli_stmt_init($conn);
                    mysqli_stmt_prepare($stmt, $sql5);
                    mysqli_stmt_bind_param($stmt, "iddiss", $idBeneficiario, $importo, $saldoBeneficiarioEffettivo, $categoria, $causale, $stato);
                    if (mysqli_stmt_execute($stmt)) {
                        header("location: ../../giroconto.php?status=ok");
                        exit();
                    }
                }
            }
        }
    } else {
        header("location: ../../riepilogoGiroconto.php?error=code%not%matched");
        echo "codice non verificato";
    }
} else {
    header("location: ../../error-404.html?error=bad%connection");
    exit();
}
