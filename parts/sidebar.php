<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link collapsed" href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <!-- MOVIMENTI -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#movimenti-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Movimenti</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="movimenti-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="rangeMovimenti.php">
                        <i class="bi bi-circle"></i><span>Per numero</span>
                    </a>
                </li>

                <li>
                    <a href="categoriaMovimenti.php">
                        <i class="bi bi-circle"></i><span>Per categoria</span>
                    </a>
                </li>

                <li>
                    <a href="dataMovimenti.php">
                        <i class="bi bi-circle"></i><span>Per data</span>
                    </a>
                </li>
            </ul>
        </li><!-- FINE MOVIMENTI -->

        <!-- RICARICA TELEFONO -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="ricaricaTelefono.php">
                <i class="bi bi-phone"></i><span>Ricarica telefonica</span>
            </a>
        </li><!-- DINE RICARICA -->

        <!-- GIROCONTO -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="giroconto.php">
                <i class="bi bi-cash-coin"></i><span>Giroconto</span>
            </a>
        </li><!-- FINE GIROCONTO -->

        <!-- BONIFICO-->
        <li class="nav-item">
            <a class="nav-link collapsed" href="bonifico.php">
                <i class="bi bi-wallet2"></i><span>Bonifico</span>
            </a>
        </li><!-- FINE BONIFICO-->

        <li class="nav-heading">Pagine utili</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="userProfile.php">
                <i class="bi bi-person"></i>
                <span>Profilo</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="assets/includes/logout.inc.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </a>
        </li>
    </ul>

</aside><!-- End Sidebar-->