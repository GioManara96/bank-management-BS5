<?php
session_start();
$idConto = $_SESSION["ContoID"];
$null = "";
include "./dbconn.inc.php";
$conn = openCon();
$sql = "UPDATE TContiCorrenti SET ImmagineProfilo = ? WHERE ContoCorrenteID = $idConto";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql);
mysqli_stmt_bind_param($stmt, "s", $null);
mysqli_stmt_execute($stmt);
header("location: ../../userProfile.php");
exit();
