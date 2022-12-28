<?php

session_start();

if(isset($_POST["changePsw"])) {
    $idConto = $_SESSION["ContoID"];
    $psw = $_POST["password"];
    $newPsw = $_POST["newpassword"];
    $renewPsw = $_POST["renewpassword"];

    if(empty($psw) || empty($newPsw) || empty($renewPsw)) {
        header("location: ../../userProfile.php?error=empty%input#profile-change-password");
        exit();
    }

    if($newPsw !== $renewPsw) {
        header("location: ../../userProfile.php?error=psw%not%matching#profile-change-password");
        exit();
    }

    require "./dbconn.inc.php";
    $conn = openCon();
    $sql = "SELECT * FROM TContiCorrenti WHERE ContoCorrenteID = $idConto AND Password = '$psw'";
    $query = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query) === 1) {
        $sql2 = "UPDATE TContiCorrenti SET Password = ? WHERE ContoCorrenteID = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql2);
        mysqli_stmt_bind_param($stmt, "si", $newPsw, $idConto);
        if(mysqli_stmt_execute($stmt)) {
            header("location: ../../userProfile.php?error=none#profile-change-password");
            exit();
        }
    } else {
        header("location: ../../userProfile.php?error=psw%not%found#profile-change-password");
        exit();
    }
} else {
    header("location: ../../error-404.html");
    exit();
}