<?php

$iban = $_POST["importo"];
$json = array();

if(is_numeric($iban)) {
    array_push($json, "<i class='bi bi-check-circle-fill text-success fs-2'></i>");
} else {
    array_push($json, "Immettere un numero, usando il . come separatore per i decimali", "<i class='bi bi-x-circle-fill text-danger fs-2'></i>");
}

echo json_encode($json);
die();
