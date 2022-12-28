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

    <title>E-Banking Bonifico</title>
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
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

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
            <h1>Riassunto Conto</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Boninfico</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section bonifico">
            <div class="row">
                <!-- RIASSUNTO CONTO -->
                <div class="col-lg-5 col-md-6">
                    <div class="card">
                        <div class="card-body info-card">
                            <h5 class="card-title mt-2">Riassunto conto</h5>

                            <div class="row align-items-center mb-3">
                                <h6 class="col-md-4 col-lg-3 mb-0">CC</h6>
                                <div class="col-md-8 col-lg-9">
                                    <p class="mb-0"><?php echo $result["CodiceTitolare"]; ?></p>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <h6 class="col-md-4 col-lg-3 mb-0">IBAN</h6>
                                <div class="col-md-8 col-lg-9">
                                    <p class="mb-0"><?php echo $result["IBAN"]; ?></p>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <h6 class="col-md-4 col-lg-3 mb-0">Saldo</h6>
                                <div class="col-md-8 col-lg-9">
                                    <?php
                                    $idConto = $_SESSION["ContoID"];
                                    $sql2 = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = $idConto ORDER BY Data DESC LIMIT 1";
                                    $query2 = mysqli_query($conn, $sql2);
                                    if (mysqli_num_rows($query) === 1) {
                                        $result2 = mysqli_fetch_assoc($query2);
                                    }
                                    ?>
                                    <p class="mb-0"><?php echo number_format($result2["Saldo"], 2, ",", "."); ?> €</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- FINE RIASSUNTO -->

                <!-- FORM BONIFICO -->
                <div class="col-lg-7 col-md-6">
                    <div class="card">
                        <div class="card-body info-card">

                            <form method="post" action="assets/includes/checkBonifico.inc.php">
                                <h5 class="card-title mt-2">Dati beneficiario</h5>

                                <?php
                                if (isset($_GET["status"])) {
                                    if ($_GET["status"] === "ok") {
                                        echo '<div class="row">';
                                        echo '<div class="col-md-11">';
                                        echo "<div class='alert alert-success alert-dismissible fade show'><i class='bi bi-check-circle-fill me-3'></i>Operazione effettuata. Controlla il tuo saldo o effettua una nuova operazione";
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                        echo "</div>";
                                        echo '<div class="col-md-4 col-lg-3"></div></div>';
                                    }
                                }

                                if (isset($_GET["error"])) {
                                    switch ($_GET["error"]) {
                                        case "empty%inputs":
                                            echo '<div class="row">';
                                            echo '<div class="col-md-11">';
                                            echo "<div class='alert alert-danger alert-dismissible fade show'><i class='bi bi-exclamation-triangle-fill me-3'></i>Compilare tutti i campi per proseguire";
                                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                            echo "</div>";
                                            echo '<div class="col-md-4 col-lg-3"></div></div>';
                                            break;
                                    }
                                }
                                ?>

                                <div class="row align-items-center">
                                    <div class="col-md-11">
                                        <label for="iban" class="form-label">IBAN:</label>
                                        <input type="text" name="iban" id="iban" class="form-control mb-3">
                                    </div>

                                    <div class="col-md-1 mt-3" id="iban_verifier"></div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-md-11">
                                        <label for="importo" class="form-label">Importo (in €):</label>
                                        <input type="text" name="importo" id="importo" class="form-control mb-3">
                                    </div>

                                    <div class="col-md-1 mt-3" id="importo_verifier"></div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <label for="dataAccredito" class="form-label">Data di accredito:</label>
                                        <input type="date" name="dataAccredito" id="dataAccredito" class="form-control mb-3">
                                    </div>

                                    <div class="col-md-1 mt-3" id="data_verifier"></div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-md-11">
                                        <label for="causaleBonifico" class="form-label">Causale:</label>
                                        <textarea class="form-control mb-4" name="causale" id="causaleBonifico" cols="10" rows="5"></textarea>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" name="sendBonifico" class="btn btn-primary">Esegui</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div><!-- FINE BONIFICO -->

            </div>
        </section>
    </main>

    <?php include "parts/footer.php"; ?>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>