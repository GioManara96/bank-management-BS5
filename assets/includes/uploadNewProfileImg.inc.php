<?php
session_start();

$idConto = $_SESSION["ContoID"];
$file = $_FILES["file"];
$fileName = $file["name"];
$fileFullPath = $file["full_path"];
$fileType = $file["type"];
$fileTmpName = $file["tmp_name"];
$fileError = $file["error"];
$fileSize = $file["size"];

$fileExt = strtolower(end(explode(".", $fileName)));
$allowedExts = ["jpeg", "jpg", "png", "pdf", "webp"];
$fileNewName = "profilo-" . uniqid("", true) . "." . $fileExt;
$fileDestination = "../img/profili/" . $fileNewName;

if (in_array($fileExt, $allowedExts)) {
    // controlliamo che non ci siano errori
    if ($file["error"] === 0) {
        // controlliamo la grandezza (in B)
        if ($file["size"] < 5000000) { // ~ 5 MB
            //avvio connessione al database
            if (move_uploaded_file($file["tmp_name"], $fileDestination)) {
                include "./dbconn.inc.php";
                $conn = openCon();
                $sql = "UPDATE TContiCorrenti SET ImmagineProfilo = ? WHERE ContoCorrenteID = $idConto";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sql);
                mysqli_stmt_bind_param($stmt, "s", $fileNewName);
                mysqli_stmt_execute($stmt);
                header("location: ../../userProfile.php");
                exit();
            }
        } else {
            header("location: ../../userProfile.php?error=size");
            exit();
        }
    }
} else {
    header("location: ../../userProfile.php?error=extension%not%allowed");
    exit();
}
