<?php

function cleanOldLogin($conn) {
    // prendo solo la data del login
    $sql = "SELECT TLogin.Data FROM TLogin";
    $query = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($query)) {
        // prendo la data come stringa dal DB
        $string = strtotime($row["Data"]); // la trasformo in data
        $loginDay = date("d", $string); // prendo solo il giorno
        $today = date("d"); // e prendo il giorno corrente
        /**
         * se è passata più di una settimana dal login registrato allora lo elimino
         */
        if($today - $loginDay > 7) {
            $delSQL = "DELETE FROM TLogin WHERE Data = '" . $row["Data"] ."';";
            mysqli_query($conn, $delSQL);
        }
    }
}