<?php

if (isset($_POST["login"])) {
    session_start();
    require "./dbconn.inc.php";

    $conn = openCon();
    $codice = $_POST["codice"]; // codice conferma

    // controllo che vengano inseriti tutti i parametri per il login
    if (empty($codice)) {
        header("location: ../../login.php?error=empty-inputs");
        exit();
    }

    // controllo che il codice sia effettivamente un codice numerico
    if (!is_numeric($codice)) {
        header("location: ../../login.php?error=invalid-code");
        exit();
    }

    $sql = "SELECT * FROM TLogin WHERE ContoCorrenteID = " . $_SESSION["ContoID"]. " AND CodiceSicurezza = '$codice'";
    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) === 1) {
        header("location: ../../index.php");
        exit();
    } else {
        header("location: ../../conferma.php");
        echo "codice non verificato";
    }
} else {
    header("location: ../../error-404.html?error=bad%connection");
    exit();
}