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

    <title>E-Banking Ricarica</title>
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
            <h1>Ricarica telefonica</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Ricarica telefono</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section movimenti">
            <div class="row">
                <!-- FORM -->
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-body movimenti-card pt-4">
                            <form method="post" action="" class="w-100">
                                <div class="row justify-content-center align-items-center mb-3 gx-1">
                                    <div class="col-md-6">
                                        <select name="operatore" class="form-select" id="operatoreTelefonico">
                                            <option value="-1">Scegli un operatore</option>
                                            <?php
                                            $sql = "SELECT * FROM TOperatoreTelefonico";
                                            $query = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                                <option value="<?php echo $row["Nome"]; ?>"><?php echo ucfirst($row["Nome"]); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <select name="importo" class="form-select" id="importoRicarica" disabled>
                                            <option value="-1">Importo</option>
                                            <option value=5">5 €</option>
                                            <option value=15">15 €</option>
                                            <option value=25">25 €</option>
                                            <option value=35">35 €</option>
                                            <option value=50">50 €</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <button type="submit" name="ricarica" class="btn btn-primary">Ricarica</button>
                                    </div>
                                </div>
                                <?php
                                    if(isset($_GET["status"])) {
                                        if($_GET["status"] === "canceled") {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class='alert alert-danger alert-dismissible fade show'><i class='bi bi-x-circle-fill me-3'></i>Operazione annullata
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                <div class="col-md-4 col-lg-3"></div>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class='alert alert-success alert-dismissible fade show'><i class='bi bi-check-circle-fill me-3'></i>Ricarica effettuata
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                <div class="col-md-4 col-lg-3"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                            </form>
                        </div>
                    </div>
                </div><!-- FINE FORM -->

                <!-- TABELLA RISULTATI -->

                <?php
                if (isset($_POST["ricarica"])) :
                    $operatore = $_POST["operatore"];
                    $importo = $_SESSION["importo"] = floatval($_POST["importo"]);

                ?>
                    <div class="col-xl-7">
                        <div class="card">
                            <div class="card-body pt-3">
                                <h5 class="card-title">Riepilogo</h5>
                                <div class="row align-items-center mb-3">
                                    <h6 class="col-md-4 col-lg-3 mb-0">Importo</h6>
                                    <div class="col-md-8 col-lg-9">
                                        <?php
                                        $sql = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = $idConto AND Stato = 'Eseguito' ORDER BY Data DESC LIMIT 1";
                                        $query = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($query) === 1) {
                                            $result = mysqli_fetch_assoc($query);
                                            $saldoPreventivo = $_SESSION["Saldo"] = $result["Saldo"] - $importo;
                                            $causale = $_SESSION["causale"] = "Ricarica " . ucfirst($operatore) . " di $importo € ";
                                        }
                                        ?>
                                        <p class="mb-0"><?php echo number_format($importo, 2, ",", "."); ?> €</p>
                                    </div>
                                </div>

                                <div class="row align-items-center mb-3">
                                    <h6 class="col-md-4 col-lg-3 mb-0">Saldo finale</h6>
                                    <div class="col-md-8 col-lg-9">
                                        <p class="mb-0"><?php echo number_format($saldoPreventivo, 2, ",", "."); ?> €</p>
                                    </div>
                                </div>

                                <div class="row align-items-center mb-3">
                                    <h6 class="col-md-4 col-lg-3 mb-0">Causale</h6>
                                    <div class="col-md-8 col-lg-9">
                                        <p class="mb-0">
                                            <?php echo empty($causale) ? "Non specificata"  : $causale; ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row align-items-center mt-5">
                                    <h6 class="col-md-8 mb-0">Confermi?
                                        <a href="assets/includes/confermaRicarica.inc.php" title="sì">
                                            <i class="bi bi-check2-square text-success fs-4 mx-3"></i>
                                        </a>

                                        <a href="ricaricaTelefono.php?status=canceled" title="no">
                                            <i class="bi bi-x-square fs-4 text-danger"></i>
                                        </a>
                                    </h6>
                                </div>
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