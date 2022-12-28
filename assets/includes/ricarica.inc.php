<?php
session_start();
if(isset($_POST["ricarica"])) {
    $operatore = $_POST["operatore"];
    $importo = $_POST["importo"];
    $idConto = $_SESSION["ContoID"];
    require "./dbconn.inc.php";
    $conn = openCon();
    $sql = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = $idConto ORDER BY Data DESC LIMIT 1";
    //echo $sql;
    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) === 1) {
        $row = mysqli_fetch_assoc($query);
        $saldoAttuale = $row["Saldo"];
        $saldoPreventivo = $saldoAttuale - $importo;
        // controllo che il saldo attuale sia sufficiente per la ricarica
        if($saldoPreventivo > 0) {
            // inserisco il movimento
            $sql2 = "INSERT INTO TMovimentiConto (ContoCorrenteID, Importo, Saldo, CategoriaMovimentoID, DescrizioneEstesa)
                    VALUES ($idConto, $importo, $saldoPreventivo, 6, 'Ricarica telefonica " . ucfirst($operatore) ." da $importo €');";
            $query2 = mysqli_query($conn, $sql2);

            if($query2) {
                header("location: ../../movimenti4.php?status=ok");
                die();
            } else {
                header("location: ../../movimenti4.php?status=ko");
                die();
            }
        } else {
            header("location: ../../movimenti4.php?error=saldo-insufficiente");
            die();
        }
    }
}