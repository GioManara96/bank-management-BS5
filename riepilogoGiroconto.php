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

    <title>E-Banking Giroconto</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

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
            <h1>Riepilogo giroconto</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="giroconto.php">Giroconto</a></li>
                    <li class="breadcrumb-item">Riepilogo</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section giroconto">
            <div class="row flex-column align-items-center">
                <!-- RIASSUNTO CONTO -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body info-card">
                            <h5 class="card-title mt-2">Dati mittente</h5>

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
                                <h6 class="col-md-4 col-lg-3 mb-0">Saldo attuale</h6>
                                <div class="col-md-8 col-lg-9">
                                    <?php
                                    $idConto = $_SESSION["ContoID"];
                                    $sql2 = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = $idConto AND Stato = 'Eseguito' ORDER BY Data DESC LIMIT 1";
                                    $query2 = mysqli_query($conn, $sql2);
                                    if (mysqli_num_rows($query) === 1) {
                                        $result2 = mysqli_fetch_assoc($query2);
                                    }
                                    ?>
                                    <p class="mb-0"><?php echo number_format($result2["Saldo"], 2, ",", "."); ?> €</p>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <h6 class="col-md-4 col-lg-3 mb-0">Importo</h6>
                                <div class="col-md-8 col-lg-9">
                                    <?php
                                    $sql3 = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = $idConto AND Stato = 'In attesa' ORDER BY Data DESC LIMIT 1";
                                    $query3 = mysqli_query($conn, $sql3);
                                    if (mysqli_num_rows($query) === 1) {
                                        $result3 = mysqli_fetch_assoc($query3);
                                        $importo = $_SESSION["importo"] = $result2["Saldo"] - $result3["Saldo"];
                                        $saldoPreventivo = $result3["Saldo"];
                                        $causale = $_SESSION["causale"] = $result3["DescrizioneEstesa"];
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

                            <h5 class="card-title mt-2">Dati beneficiario</h5>

                            <div class="row align-items-center mb-3">
                                <h6 class="col-md-4 col-lg-3 mb-0">Nome completo</h6>
                                <?php
                                $sql4 = "SELECT * FROM TContiCorrenti WHERE IBAN = '" . $_SESSION["ibanBeneficiario"] . "'";
                                $query4 = mysqli_query($conn, $sql4);
                                if (mysqli_num_rows($query) === 1) {
                                    $result4 = mysqli_fetch_assoc($query4);
                                }
                                ?>
                                <div class="col-md-8 col-lg-9">
                                    <p class="mb-0"><?php echo $result4["NomeTitolare"]; ?></p>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <h6 class="col-md-4 col-lg-3 mb-0">IBAN</h6>
                                <div class="col-md-8 col-lg-9">
                                    <p class="mb-0"><?php echo $result4["IBAN"]; ?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- FINE RIASSUNTO -->

                <!-- FORM CODICE VERIFICA -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mt-2">Codice di sicurezza</h5>
                            <?php
                            if (isset($_GET["error"])) {
                                switch ($_GET["error"]) {
                                    case "empty%input":
                                        echo '<div class="row">';
                                        echo '<div class="col-md-8 col-lg-9">';
                                        echo "<div class='alert alert-danger alert-dismissible fade show'><i class='bi bi-exclamation-triangle-fill me-3'></i>Compila il campo di sicurezza";
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                        echo "</div>";
                                        echo '<div class="col-md-4 col-lg-3"></div></div>';
                                        break;
                                    case "invalid%code":
                                        echo '<div class="row">';
                                        echo '<div class="col-md-8 col-lg-9">';
                                        echo "<div class='alert alert-warning alert-dismissible fade show'><i class='bi bi-exclamation-triangle-fill me-3'></i>Il codice deve essere numerico";
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                        echo "</div>";
                                        echo '<div class="col-md-4 col-lg-3"></div>';
                                        break;
                                    case "code%not%matched":
                                        echo '<div class="row">';
                                        echo '<div class="col-md-8 col-lg-9">';
                                        echo "<div class='alert alert-danger alert-dismissible fade show'><i class='bi bi-x-circle-fill me-3'></i>Il codice non corrisponde";
                                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                        echo "</div>";
                                        echo '<div class="col-md-4 col-lg-3"></div>';
                                        break;
                                }
                            }
                            ?>
                            <form method="post" action="assets/includes/confermaGiroconto.inc.php">
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-8 col-lg-9">
                                        <input type="text" name="codice" placeholder="codice di sicurezza" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-lg-3">
                                        <button type="submit" name="conferma" class="btn btn-primary">Verifica</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </main>

    <?php include "parts/footer.php"; ?>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>