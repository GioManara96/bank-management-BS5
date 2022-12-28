<?php

if (isset($_POST["conferma"])) {
    session_start();
    require "./dbconn.inc.php";

    $conn = openCon();
    $idConto = $_SESSION["ContoID"];
    $dataAccredito = $_SESSION["dataAccredito"];
    $codice = $_POST["codice"];
    $stato = "In attesa";

    // controllo che vengano inseriti tutti i parametri per il login
    if (empty($codice)) {
        header("location: ../../riepilogoBonifico.php?error=empty%input");
        exit();
    }

    // controllo che il codice sia effettivamente un codice numerico
    if (!is_numeric($codice)) {
        header("location: ../../riepilogoBonifico.php?error=invalid%code");
        exit();
    }

    $sql = "SELECT * FROM TLogin WHERE ContoCorrenteID = $idConto AND CodiceSicurezza = '$codice'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) === 1) {
        // inserisco l'operazione nel sistema con la data da eseguire
        $sql2 = "UPDATE TMovimentiConto SET Stato = ? WHERE ContoCorrenteID = ? AND `Data` = ?;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql2);
        mysqli_stmt_bind_param($stmt, "sis", $stato, $idConto, $dataAccredito);
        if(mysqli_stmt_execute($stmt)) {
            header("location: ../../bonifico.php?status=ok");
            exit();
        }
    }
} else {
    header("location: ../../error-404.html");
    exit();
}