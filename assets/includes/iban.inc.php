<?php

$iban = $_POST["iban"];
$json = array();
require "./dbconn.inc.php";
$conn = openCon();
$sql = "SELECT * FROM TContiCorrenti WHERE IBAN = '$iban'";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) === 1) {
    array_push($json, "<i class='bi bi-check-circle-fill text-success fs-2'></i>");
} else {
    array_push($json, "Il destinatario del bonifico deve essere un altro cliente della nostra banca", "<i class='bi bi-x-circle-fill text-danger fs-2'></i>");
}

echo json_encode($json);
die();
