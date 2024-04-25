<?php
require "db_connection.php";
if (!empty($pdo)) {
    $str = "select Descrizione_Categoria
from CategoriaEventi";

$str2="select Descrizione,Descrizione_Categoria,Prezzo
from Eventi
join CategoriaEventi on Eventi.Categoria = CategoriaEventi.ID_Categoria
where CategoriaEventi.Descrizione_Categoria like 'Concerti'"
;
    $statement = $pdo -> query($str);
    $statement2 = $pdo -> query($str2);
    if (!$statement){
        echo "ERROR";
    }
    else if (!$statement2){
         echo "ERROR";
     }

     else{
        $results = $statement -> fetchAll();
        $results2 = $statement2 -> fetchAll();
    }


}

?>

<!DOCTYPE>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <title>
        HOME
    </title>
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
                foreach ($results as $row){
                    ?>

                        <button type="button" class="btn btn-success">

                            <a href="#" class="link-light">
                                <?= $row["Descrizione_Categoria"] ?>
                            </a>

                        </button>


                    <?php } ?>

            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<?php

foreach ($results2 as $row2){

    ?>

<p>
    <?= $row2["Descrizione"] ?>
</p>

<?php } ?>


</body>
</html>














