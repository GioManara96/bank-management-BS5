<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Riservata</title>
    <!-- Font awesome -->
    <script src="https://kit.fontawesome.com/3ac5c91e2b.js" crossorigin="anonymous"></script>
    <!-- Bootstrap 5-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- extra fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">
    <!-- stili -->
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>

<body>
    <div class="container-fluid">
        <!-- ==== HERO ==== -->
        <div class="hero mx-auto p-3 row">
            <!-- ==== ISTRUZIONI ==== -->
            <div class="col">
                <div class="istruzioni">
                    <h5 class="mb-3">Accesso cliente</h5>
                    <h6 class="mb-0"><i class="fa-solid fa-key me-2"></i>Come accedere</h6>
                    <p class="px-3">Inserisci il Codice cliente e la Password. Successivamente, ti invieremo una email con codice di conferma.</p>
                    <h6 class="mb-0"><i class="fa-solid fa-shield me-2"></i>Come proteggiamo i tuoi dati</h6>
                    <p class="px-3">I dati che inserisci e le transazioni effettuate sono protetti da crittografia a 128 bit certificata da Verisign.</p>
                </div>
            </div><!-- ==== END ISTRUZIONI ==== -->

            <!-- ==== FORM LOGIN === -->
            <div class="col">
                <form action="./assets/includes/login.inc.php" method="POST" class="d-flex justify-content-center flex-column p-3">
                    <?php
                    if (isset($_GET["error"])) {
                        switch ($_GET["error"]) {
                            case "badconn":
                                echo "<div class='alert alert-danger'>Effettuare il login per accedere.</div>";
                                break;
                            case "empty-inputs":
                                echo "<div class='alert alert-danger'>Compilare tutti i campi.</div>";
                                break;
                            case "invalid-code":
                                echo "<div class='alert alert-danger'>Il codice titolare deve essere numerico.</div>";
                                break;
                            case "not-found":
                                echo "<div class='alert alert-danger'>Utente non trovato. Controllare i valori inseriti.</div>";
                                break;
                        }
                    }
                    ?>
                    <label class="form-label" for="codice">Codice Cliente</label>
                    <input type="text" id="codice" name="codice" class="mb-2">
                    <label class="form-label" for="psw">Password</label>
                    <input type="password" id="psw" name="psw" class="mb-3">
                    <div class="d-grid">
                        <button type="submit" name="login">Accedi</button>
                    </div>
                </form>
            </div><!-- ==== END FORM LOGIN ==== -->
        </div><!-- ==== END HERO ==== -->
    </div>

</body>

</html>