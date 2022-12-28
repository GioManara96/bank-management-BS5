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

    <title>E-Banking Profili</title>
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
            <h1>Profilo</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Utente</li>
                    <li class="breadcrumb-item active">Profilo</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                            <img src="assets/img/profili/<?php echo $result["ImmagineProfilo"]; ?>" alt="Profile" class="rounded-circle">
                            <h2><?php echo $result["NomeTitolare"]; ?></h2>
                            <p class="subtitle">CODICE CLIENTE: <?php echo $result["CodiceTitolare"]; ?></p>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- NAVIGAZIONE TABS -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Riassunto</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modifica Profilo</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Cambia Password</button>
                                </li>

                            </ul><!-- FINE NAVIGAZIONE TABS -->

                            <!-- CONTENUTO TABS -->
                            <div class="tab-content pt-2">

                                <!-- RIASSUNTO -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <!-- alerts -->
                                    <?php
                                    if (isset($_GET["error"])) {
                                        switch ($_GET["error"]) {
                                            case "size":
                                                echo "<div class='alert alert-danger'>File troppo grande</div>";
                                                break;
                                            case "extension%not%allowed":
                                                echo "<div class='alert alert-danger'>Estensione del file non permessa.</div>";
                                                break;
                                        }
                                    }
                                    ?>
                                    <!-- fine alerts -->
                                    <h5 class="card-title">Dettagli Profilo</h5>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label ">Nome Completo</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $result["NomeTitolare"]; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Professione</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $result["Professione"]; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Paese</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $result["Paese"]; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Indirizzo</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $result["Indirizzo"]; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">CAP</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $result["CAP"]; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Telefono</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $result["Telefono"]; ?></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3 col-md-4 label">Email</div>
                                        <div class="col-lg-9 col-md-8"><?php echo $result["Email"]; ?></div>
                                    </div>

                                </div><!-- FINE RIASSUNTO -->

                                <!-- MODIFICA PROFILO  -->
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                    <form method="post" action="assets/includes/uploadNewProfileImg.inc.php" class="upload_form" id="uploadImageForm" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="assets/img/profili/<?php echo $result["ImmagineProfilo"]; ?>" alt="Profile">
                                                <div class="pt-2">
                                                    <label tpe="button" class="btn btn-primary btn-sm text-white" for="uploadProfileImg" title="Upload new profile image">
                                                        <i class="bi bi-upload"></i>
                                                    </label>
                                                    <input type="file" class="d-none" id="uploadProfileImg" name="file">
                                                    <a href="assets/includes/deleteProfileImg.inc.php" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <form method="post" action="assets/includes/editProfile.inc.php">

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome Completo</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input type="text" class="form-control" id="fullName" value="<?php echo $result["NomeTitolare"]; ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Job" class="col-md-4 col-lg-3 col-form-label">Professione</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="job" type="text" class="form-control" id="Job" placeholder="<?php echo $result["Professione"]; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Country" class="col-md-4 col-lg-3 col-form-label">Paese</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="country" type="text" class="form-control" id="Country" placeholder="<?php echo $result["Paese"]; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Indirizzo</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="address" type="text" class="form-control" id="Address" placeholder="<?php echo $result["Indirizzo"]; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="CAP" class="col-md-4 col-lg-3 col-form-label">CAP</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="CAP" type="text" class="form-control" id="CAP" placeholder="<?php echo $result["CAP"]; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Telefono</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="phone" type="text" class="form-control" id="Phone" placeholder="<?php echo $result["Telefono"]; ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="email" type="email" class="form-control" id="Email" placeholder="<?php echo $result["Email"]; ?>">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" name="editProfile" class="btn btn-primary">Salva i cambiamenti</button>
                                        </div>
                                    </form>

                                </div><!-- FINE MODIFICA PROFILO -->

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->
                                    <form method="post" action="assets/includes/changePsw.inc.php">
                                        <?php
                                        if (isset($_GET["error"])) {
                                            switch ($_GET["error"]) {
                                                case "empty%input":
                                                    echo '<div class="row"><div class="col-md-4 col-lg-3"></div>';
                                                    echo '<div class="col-md-8 col-lg-9">';
                                                    echo "<div class='alert alert-danger alert-dismissible fade show'><i class='bi bi-exclamation-triangle-fill me-3'></i>Compila tutti i campi";
                                                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                                    echo "</div></div>";
                                                    break;
                                                case "psw%not%found":
                                                    echo '<div class="row"><div class="col-md-4 col-lg-3"></div>';
                                                    echo '<div class="col-md-8 col-lg-9">';
                                                    echo "<div class='alert alert-danger alert-dismissible fade show'><i class='bi bi-exclamation-triangle-fill me-3'></i>Password originale errata.";
                                                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                                    echo "</div></div>";
                                                    break;
                                                case "psw%not%matching":
                                                    echo '<div class="row"><div class="col-md-4 col-lg-3"></div>';
                                                    echo '<div class="col-md-8 col-lg-9">';
                                                    echo "<div class='alert alert-warning alert-dismissible fade show'><i class='bi bi-exclamation-triangle-fill me-3'></i>Le due passwords non corrispondono";
                                                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                                    echo "</div></div>";
                                                    break;
                                                case "none":
                                                    echo '<div class="row"><div class="col-md-4 col-lg-3"></div>';
                                                    echo '<div class="col-md-8 col-lg-9">';
                                                    echo "<div class='alert alert-success alert-dismissible fade show'><i class='bi bi-check-circle-fill me-3'></i>Password aggiornata.";
                                                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                                                    echo "</div></div>";
                                                    break;
                                            }
                                        }
                                        ?>
                                        <div class="row mb-3">
                                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="password" type="password" class="form-control" id="currentPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Nuova Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="newpassword" type="password" class="form-control" id="newPassword">
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-inserire Nuova Password</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" name="changePsw" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </form><!-- End Change Password Form -->

                                </div>

                            </div><!-- FINE CONTENUTO TABS -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <?php include "parts/footer.php"; ?>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>