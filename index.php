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

    <title>E-Banking Dashboard</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">

                        <!-- Reports -->
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">
                                    <h5 class="card-title">Saldo <span>/Movimenti</span></h5>

                                    <!-- Line Chart -->
                                    <?php
                                    $idConto = $_SESSION["ContoID"];
                                    $saldo = array();
                                    $movimenti = array();
                                    $data = array();
                                    $sql = "SELECT * FROM TMovimentiConto WHERE ContoCorrenteID = $idConto;";
                                    $query = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        array_push($saldo, $row["Saldo"]);
                                        array_push($movimenti, $row["Importo"]);
                                        array_push($data, explode(" ", $row["Data"])[0]);
                                    }
                                    ?>
                                    <div id="reportsChart" data-saldo="<?php echo implode(",", $saldo); ?>" data-movimenti="<?php echo implode(",", $movimenti); ?>" data-data="<?php echo implode(",", $data); ?>"></div>
                                    <!-- End Line Chart -->

                                </div>

                            </div>
                        </div><!-- End Reports -->

                        <!-- Ultimi Movimenti -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">Ultimi Movimenti</h5>
                                    <?php
                                    $sql2 = "SELECT TMovimentiConto.*, TCategoriaMovimenti.* FROM TMovimentiConto INNER JOIN TCategoriaMovimenti
                                            ON TMovimentiConto.CategoriaMovimentoID=TCategoriaMovimenti.CategoriaMovimentoID WHERE TMovimentiConto.ContoCorrenteID = 
                                            $idConto ORDER BY Data DESC";
                                    $query2 = mysqli_query($conn, $sql2);
                                    ?>
                                    <table class="table table-borderless datatable">
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
                                            while ($row2 = mysqli_fetch_assoc($query2)) : ?>
                                                <tr>
                                                    <th scope="row"><?php echo $row2["MovimentoID"]; ?></th>
                                                    <td><?php echo $row2["Data"]; ?></td>
                                                    <td>
                                                    <?php
                                                        if ($row2["Tipologia"] === "Entrata") {
                                                            echo "+";
                                                        } else {
                                                            echo "-";
                                                        }
                                                        ?>
                                                        <?php echo number_format($row2["Importo"], 2, ",", "."); ?> €
                                                    </td>
                                                    <td><?php echo $row2["NomeCategoria"]; ?></td>
                                                    <td>
                                                        <?php
                                                        switch ($row2["Stato"]) {
                                                            case "Eseguito":
                                                                echo '<span class="badge bg-success">' . $row2["Stato"] . '</span>';
                                                                break;
                                                            case "In attesa":
                                                                echo '<span class="badge bg-warning">' . $row2["Stato"] . '</span>';
                                                                break;
                                                            case "Cancellato":
                                                                echo '<span class="badge bg-danger">' . $row2["Stato"] . '</span>';
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row2["DescrizioneEstesa"]; ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div><!-- End Recent Sales -->
                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">

                    <!-- Recent Activity -->
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Recent Activity <span>| Today</span></h5>

                            <div class="activity">

                                <div class="activity-item d-flex">
                                    <div class="activite-label">32 min</div>
                                    <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                    <div class="activity-content">
                                        Quia quae rerum <a href="#" class="fw-bold text-dark">explicabo officiis</a> beatae
                                    </div>
                                </div><!-- End activity item-->

                                <div class="activity-item d-flex">
                                    <div class="activite-label">56 min</div>
                                    <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                                    <div class="activity-content">
                                        Voluptatem blanditiis blanditiis eveniet
                                    </div>
                                </div><!-- End activity item-->

                                <div class="activity-item d-flex">
                                    <div class="activite-label">2 hrs</div>
                                    <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                                    <div class="activity-content">
                                        Voluptates corrupti molestias voluptatem
                                    </div>
                                </div><!-- End activity item-->

                                <div class="activity-item d-flex">
                                    <div class="activite-label">1 day</div>
                                    <i class='bi bi-circle-fill activity-badge text-info align-self-start'></i>
                                    <div class="activity-content">
                                        Tempore autem saepe <a href="#" class="fw-bold text-dark">occaecati voluptatem</a> tempore
                                    </div>
                                </div><!-- End activity item-->

                                <div class="activity-item d-flex">
                                    <div class="activite-label">2 days</div>
                                    <i class='bi bi-circle-fill activity-badge text-warning align-self-start'></i>
                                    <div class="activity-content">
                                        Est sit eum reiciendis exercitationem
                                    </div>
                                </div><!-- End activity item-->

                                <div class="activity-item d-flex">
                                    <div class="activite-label">4 weeks</div>
                                    <i class='bi bi-circle-fill activity-badge text-muted align-self-start'></i>
                                    <div class="activity-content">
                                        Dicta dolorem harum nulla eius. Ut quidem quidem sit quas
                                    </div>
                                </div><!-- End activity item-->

                            </div>

                        </div>
                    </div><!-- End Recent Activity -->

                    
                    <!-- News & Updates Traffic -->
                    <div class="card">
                        <div class="filter">
                            <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <li class="dropdown-header text-start">
                                    <h6>Filter</h6>
                                </li>

                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>

                        <div class="card-body pb-0">
                            <h5 class="card-title">News &amp; Updates <span>| Today</span></h5>

                            <div class="news">
                                <div class="post-item clearfix">
                                    <img src="assets/img/news-1.jpg" alt="">
                                    <h4><a href="#">Nihil blanditiis at in nihil autem</a></h4>
                                    <p>Sit recusandae non aspernatur laboriosam. Quia enim eligendi sed ut harum...</p>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/news-2.jpg" alt="">
                                    <h4><a href="#">Quidem autem et impedit</a></h4>
                                    <p>Illo nemo neque maiores vitae officiis cum eum turos elan dries werona nande...</p>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/news-3.jpg" alt="">
                                    <h4><a href="#">Id quia et et ut maxime similique occaecati ut</a></h4>
                                    <p>Fugiat voluptas vero eaque accusantium eos. Consequuntur sed ipsam et totam...</p>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/news-4.jpg" alt="">
                                    <h4><a href="#">Laborum corporis quo dara net para</a></h4>
                                    <p>Qui enim quia optio. Eligendi aut asperiores enim repellendusvel rerum cuder...</p>
                                </div>

                                <div class="post-item clearfix">
                                    <img src="assets/img/news-5.jpg" alt="">
                                    <h4><a href="#">Et dolores corrupti quae illo quod dolor</a></h4>
                                    <p>Odit ut eveniet modi reiciendis. Atque cupiditate libero beatae dignissimos eius...</p>
                                </div>

                            </div><!-- End sidebar recent posts-->

                        </div>
                    </div><!-- End News & Updates -->

                </div><!-- End Right side columns -->

            </div>
        </section>

    </main><!-- End #main -->

    <?php include "parts/footer.php"; ?>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>