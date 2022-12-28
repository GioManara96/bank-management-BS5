<?php
session_start();

if (isset($_SESSION["ContoID"])) {
    $idConto = $_SESSION["ContoID"];
    $importo = $_SESSION["importo"];
    $saldoPreventivo = $_SESSION["Saldo"];
    $categoria = 6;
    $causale = $_SESSION["causale"];
    $stato = "Eseguito";

    require "./dbconn.inc.php";
    $conn = openCon();
    $sql = "INSERT INTO TMovimentiConto (ContoCorrenteID, Importo, Saldo, CategoriaMovimentoID, DescrizioneEstesa, Stato)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "iddiss", $idConto, $importo, $saldoPreventivo, $categoria, $causale, $stato);
    if (mysqli_stmt_execute($stmt)) {
        header("location: ../../ricaricaTelefono.php?status=ok");
        exit();
    }
} else {
    header("location: ../../error-404.html");
    exit();
}
