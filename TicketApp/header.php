<?php
require_once "Database\DB_connection.php";
session_start();

if (!empty($pdo)) {
    $query = "SELECT Descrizione_Categoria  FROM CategoriaEventi;";
    $statement = $pdo -> query($query);

    if (!$statement){
        echo "ERROR";
    }
    else{
        $categorie = $statement -> fetchAll();
    }
}
?>

<!DOCTYPE>
<html>
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://kit.fontawesome.com/d51081ccfb.js" crossorigin="anonymous"></script>
    <script src="carrelloScript.js" defer></script>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <title>WaveTickets</title>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid ">
        <a href="index.php" class="navbar-brand">
            <img src="images/arancioBianco.png" class="logo" alt="Logo">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-between"> <!-- Modifica qui -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link">HOME</a>
                </li>
                <?php
                foreach ($categorie as $row){
                    foreach ($row as $descrizione){
                        ?>
                        <li class="nav-item">
                            <a href="categoria.php?categoria=<?= $descrizione?>" class="nav-link"><?= $descrizione?></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <form class="d-flex form-group mb-0" method="get" action="risultati.php">
                        <input class="form-control me-1" type="search" id="search" name="search" placeholder="Search" autocomplete="off">
                        <button class="btn btn-outline-light" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </li>
                <?php
                if(isset($_SESSION['user'])){
                    if(!empty($pdo)){
                        $carrello = "SELECT COUNT(*) AS numCarrello FROM Carrello WHERE Carrello.Utente = " . $_SESSION['user'] . ";";
                        $statement2 = $pdo -> query($carrello);

                        if(!$statement2){
                            echo "ERROR";
                        }
                        else{
                            $numCarrello = $statement2 -> fetchAll();
                        }
                    }
                    ?>
                    <li class="nav-item">
                        <a href="carrello.php" class="nav-link position-relative">
                            <i class="bi bi-cart"></i>
                            CARRELLO
                            <?php
                                if($numCarrello[0]["numCarrello"] > 0){
                            ?>
                                    <span class="position-absolute top-75 translate-middle badge rounded-pill bg-primary bg-white">
                                        <?= $numCarrello[0]["numCarrello"]?>
                                    </span>
                            <?php
                                }
                            ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="account.php" class="nav-link">
                            <i class="bi bi-person-fill"></i>
                            ACCOUNT
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">
                            <i class="bi bi-box-arrow-in-left"></i>
                            LOGOUT
                        </a>
                    </li>
                    <?php
                }
                else{
                    ?>
                    <li class="nav-item">
                        <a href="carrello.php" class="nav-link position-relative">
                            <i class="bi bi-cart"></i>
                            CARRELLO
                            <?php
                                if(isset($_SESSION["NotLog"])){
                            ?>
                                    <span class="position-absolute top-75 translate-middle badge rounded-pill bg-primary bg-white">
                                        <?=count($_SESSION["NotLog"])?>
                                    </span>
                            <?php
                                }
                            ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="registration.php" class="nav-link">
                            <i class="bi bi-person"></i>
                            REGISTRAZIONE
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">
                            <i class="bi bi-box-arrow-in-right"></i>
                            LOGIN
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
