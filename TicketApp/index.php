<?php
    require "db_connection.php";
    session_start();

    $arrayCategorie = array();
    if(!isset($_SESSION['user'])){
        //HOMEPAGE NORMALE
        if (!empty($pdo)) {
            $query = "SELECT Descrizione_Categoria  FROM CategoriaEventi;";
            $statement = $pdo -> query($query);

            if (!$statement){
                echo "ERROR";
            }
            else{
                $categorie = $statement -> fetchAll();
                foreach ($categorie as $value){
                    foreach ($value as $item){
                        array_push($arrayCategorie, $item);
                        $query2="SELECT Eventi.Descrizione, CategoriaEventi.Descrizione_Categoria, Eventi.Prezzo
                           FROM Eventi JOIN CategoriaEventi ON Eventi.Categoria = CategoriaEventi.ID_Categoria
                           WHERE CategoriaEventi.Descrizione_Categoria LIKE '$item';";

                        $statement2 = $pdo -> query($query2);
                        $results = $statement2 -> fetchAll();
                    }
                }
            }
        }
    }
    else{
        //HOMEPAGE CONSIGLIATA
    }

?>

<!DOCTYPE>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <title>HOME</title>
</head>
<body>

<header class="site-header">

</header>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <?php
                foreach ($categorie as $row){
                    foreach ($row as $descrizione){
                    ?>

                        <button type="button" class="btn btn-success">

                            <a href="#" class="link-light">
                                <?= $descrizione?>
                            </a>

                        </button>


                <?php
                    }
                }
                ?>

            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<?php
    foreach ($arrayCategorie as $value){
            array_push($arrayCategorie, $item);
            $query3="SELECT Eventi.Descrizione, Eventi.Prezzo
                               FROM Eventi JOIN CategoriaEventi ON Eventi.Categoria = CategoriaEventi.ID_Categoria
                               WHERE CategoriaEventi.Descrizione_Categoria LIKE '$value';";

            $statement3 = $pdo -> query($query3);
            $eventi = $statement3 -> fetchAll();
?>
        <h1><?= $value?></h1>
<?php
            foreach ($eventi as $evento){
?>
                <div>
                    <img src="images\default.jpg">
                    <p><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?></p>
                </div>
<?php
            }
    }
?>

</body>
</html>













