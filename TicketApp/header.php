<?php
    require_once "DB_connection.php";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>EVENTINOW</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <form class="d-flex" method="get" action="#">
                        <input class="form-control me-2" type="search" placeholder="Search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                </li>
                <?php
                    if(isset($_SESSION['user'])){
                ?>
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