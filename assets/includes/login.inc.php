<?php
require "../../vendor/autoload.php";    // richiedo l'autovendor
use PHPMailer\PHPMailer\PHPMailer;  // specifico la libreria composer da utilizzare

if (isset($_POST["login"])) {
    session_start();
    require "./dbconn.inc.php"; // richiedo file con funzioni per la connessione

    $conn = openCon();  // apro la connessione
    $codice = $_POST["codice"]; // codice cliente
    $psw = $_POST["psw"];   // password account

    // controllo che vengano inseriti tutti i parametri per il login
    if (empty($codice) || empty($psw)) {
        header("location: ../../login.php?error=empty-inputs");
        exit();
    }

    // controllo che il codice sia effettivamente un codice numerico
    if (!is_numeric($codice)) {
        header("location: ../../login.php?error=invalid-code");
        exit();
    }
    // cerco nel DB un CC a cui corrispondando codice titolare e password
    $sql = "SELECT * FROM TContiCorrenti WHERE CodiceTitolare = $codice AND Password = '$psw'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) === 1) {
        $result = mysqli_fetch_assoc($query);
        // questi dati mi torneranno utili in seguito
        $_SESSION["NomeTitolare"] = $result["NomeTitolare"];
        $_SESSION["Email"] = $result["Email"];
        $_SESSION["ContoID"] = $result["ContoCorrenteID"];

        $address = $result["Email"];
        $security = random_int(10000, 999999);  // codice di sicurezza per la seconda fase di validazione del login

        // lo vado ad aggiungere nella tabella dei login per confermare che per quel conto corrente ci sia un tentativo di accesso
        $sql2 = "INSERT INTO TLogin (ContoCorrenteID, CodiceSicurezza) VALUES (" . $_SESSION["ContoID"] . ", $security)";
        $query2 = mysqli_query($conn, $sql2);

        // lancio una funzione per pulire i vecchi login ed evitare che intasino il DB
        include "./functions.inc.php";
        cleanOldLogin($conn);

        // spedisco una mail col codice di conferma
        $mail = new PHPMailer();
        $mail->isSMTP(); // using SMTP protocol                                     
        $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
        $mail->SMTPAuth = true;  // enable smtp authentication                             
        $mail->Username = 'email';  // sender gmail host              
        $mail->Password = 'password'; // sender gmail host password                          
        $mail->SMTPSecure = 'tls';  // for encrypted connection                           
        $mail->Port = 587;   // port for SMTP 

        $mail->setFrom("email", "Codice sicurezza banca"); // sender's email and name
        $mail->addAddress($address, $result["Nome Titolare"]);   // receiver's email

        $mail->Subject = "Codice di conferma";
        $mail->Body = "Codice di conferma: $security";

        if ($mail->send()) {
            // se la email viene spedita controllo dalla tabella dei login che il codice corrisponda
            $sql3 = "SELECT * FROM TLogin WHERE ContoCorrenteID = " . $_SESSION["ContoID"] . " ORDER BY Data DESC LIMIT 1";
            $query3 = mysqli_query($conn, $sql3);
            // in caso affermativo vado all'index
            if (mysqli_num_rows($query3) === 1) {
                header("location: ../../confermaLogin.php");
                exit();
            } else {
                header("location: ../../confermaLogin.php");
                echo "codice non verificato";
            }
        } else {
            echo "email non inviata";
        }
    } else {
        header("location: ../../login.php?error=not-found");
        exit();
    }
} else {
    header("location: ../../error-404.html?error=bad%connection");
    exit();
}
