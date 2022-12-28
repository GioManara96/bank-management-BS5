<?php
session_start();

if(isset($_POST["editProfile"])) {
    require "./dbconn.inc.php";
    $idConto = $_SESSION["ContoID"];
    $conn = openCon();
    $job = strtolower($_POST["job"]);
    $paese = $_POST["country"];
    $address = $_POST["address"];
    $cap = $_POST["CAP"];
    $tel = $_POST["phone"];
    $email = $_POST["email"];

    // edit professione
    if(!empty($job)) {
        $sql = "UPDATE TContiCorrenti SET Professione = ? WHERE ContoCorrenteID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "si", ucfirst($job), $idConto);
        mysqli_stmt_execute($stmt);
    }

    // edit paese
    if(!empty($paese)) {
        $sql = "UPDATE TContiCorrenti SET Paese = ? WHERE ContoCorrenteID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "si", ucfirst($paese), $idConto);
        mysqli_stmt_execute($stmt);
    }

    // edit indirizzo
    if(!empty($address)) {
        $sql = "UPDATE TContiCorrenti SET Indirizzo = ? WHERE ContoCorrenteID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "si", ucfirst($address), $idConto);
        mysqli_stmt_execute($stmt);
    }

    // edit CAP
    if(!empty($cap)) {
        $sql = "UPDATE TContiCorrenti SET CAP = ? WHERE ContoCorrenteID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "si", ucfirst($cap), $idConto);
        mysqli_stmt_execute($stmt);
    }

    // edit telefono
    if(!empty($tel)) {
        $sql = "UPDATE TContiCorrenti SET Telefono = ? WHERE ContoCorrenteID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "si", ucfirst($tel), $idConto);
        mysqli_stmt_execute($stmt);
    }

    // edit email
    if(!empty($email)) {
        $sql = "UPDATE TContiCorrenti SET Email = ? WHERE ContoCorrenteID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "si", $email, $idConto);
        mysqli_stmt_execute($stmt);
    }

    header("location: ../../userProfile.php");
    exit();
} else {
    header("location: ../../error-404.html?error=bad%connection");
    exit();
}