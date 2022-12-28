<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="assets/img/logo_.png" alt="">
            <span class="d-none d-lg-block">E-banking</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <!-- QUERY PHP da cui prelevo i dati -->
            <?php
            include "assets/includes/dbconn.inc.php";
            $idConto = $_SESSION["ContoID"];
            $conn = openCon();
            $sql = "SELECT * FROM TContiCorrenti WHERE ContoCorrenteID = $idConto;";
            $query = mysqli_query($conn, $sql);

            if (mysqli_num_rows($query) === 1) {
                $result = mysqli_fetch_assoc($query);
            }
            ?>
            <!-- FINE QUERY -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="assets/img/profili/<?php echo $result["ImmagineProfilo"]; ?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        <!-- scrivo la prima lettera del nome e il congome intero -->
                        <?php echo explode(" ", $result["NomeTitolare"])[0][0] . ". " . explode(" ", $result["NomeTitolare"])[1]; ?>
                    </span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $result["NomeTitolare"]; ?></h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="userProfile.php">
                            <i class="bi bi-person"></i>
                            <span>Profilo</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="userProfile.php#profile-edit">
                            <i class="bi bi-gear"></i>
                            <span>Modifica informazioni</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="userProfile.php#profile-change-password">
                            <i class="bi bi-lock"></i>
                            <span>Cambia Password</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="assets/includes/logout.inc.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->