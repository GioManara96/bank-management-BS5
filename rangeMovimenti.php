<?php
session_start();
if (!isset($_SESSION["ContoID"])) {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>E-Banking Movimenti</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin - v2.4.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <?php include "parts/header.php"; ?>

    <?php include "parts/sidebar.php"; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Movimenti per numero</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Movimenti</li>
                    <li class="breadcrumb-item active">Per numero</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section movimenti">
            <div class="row">
                <!-- FORM -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body movimenti-card pt-4">
                            <form method="post" action="" class="w-100">
                                <div class="row justify-content-center align-items-center mb-3">
                                    <input type="number" class="col-md-8 col-lg-9 form-control w-auto" id="range" name="range" placeholder="numero movimenti">
                                    <div class="col-md-4 col-lg-3">
                                        <button type="submit" name="cerca" class="btn btn-primary">CERCA</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- FINE FORM -->

                <!-- TABELLA RISULTATI -->

                <?php
                if (isset($_POST["cerca"])) :
                    $limit = $_POST["range"];
                    $sql = "SELECT TMovimentiConto.*, TCategoriaMovimenti.* FROM TMovimentiConto INNER JOIN TCategoriaMovimenti
                                ON TMovimentiConto.CategoriaMovimentoID=TCategoriaMovimenti.CategoriaMovimentoID WHERE TMovimentiConto.ContoCorrenteID = " .
                        $_SESSION["ContoID"] . " ORDER BY Data DESC LIMIT $limit";
                    $query = mysqli_query($conn, $sql);

                ?>
                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body pt-3">
                                <table class="table order-column" id="risultati_ricerca">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Data</th>
                                            <th>Importo</th>
                                            <th>Tipologia</th>
                                            <th>Stato</th>
                                            <th>Dettagli</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($query) > 0) {
                                            $i = 1;
                                            $data = array();
                                            while ($row = mysqli_fetch_assoc($query)) {
                                                $csv_rows = array($row["MovimentoID"], $row["Data"], $row["Importo"], $row["NomeCategoria"], $row["Stato"]);
                                                array_push($data, $csv_rows);
                                                $_SESSION["dataCSV"] = $data;
                                        ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo date("d/m/Y", strtotime($row["Data"])); ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row["Tipologia"] === "Entrata") {
                                                            echo "+";
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                        <?php echo number_format($row["Importo"], 2, ",", "."); ?> €
                                                    </td>
                                                    <td><?php echo $row["NomeCategoria"]; ?></td>
                                                    <td>
                                                        <?php
                                                        switch($row["Stato"]){
                                                            case "Eseguito":
                                                                echo '<span class="badge bg-success">' . $row["Stato"] . '</span>';
                                                                break;
                                                            case "In attesa":
                                                                echo '<span class="badge bg-warning">' . $row["Stato"] . '</span>';
                                                                break;
                                                            case "Cancellato":
                                                                echo '<span class="badge bg-danger">' . $row["Stato"] . '</span>';
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><a href="dettagli.php?id=<?php echo $row["MovimentoID"]; ?>">Dettagli</a></td>
                                                </tr>
                                        <?php
                                                $i++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <a href="assets/includes/exportCSV.inc.php" style="float: right; font-size: 12px;">
                                    <i class="bi bi-filetype-csv me-3 text-success"></i>Esporta risultati in CSV
                                </a>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div><!-- FINE TABELLA -->
            </div>
        </section>

    </main>

    <?php include "parts/footer.php"; ?>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>