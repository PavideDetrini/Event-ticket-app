<?php
    include_once "header.php";
    require "db_connection.php";
    session_start();

    $arrayCategorie = array();
    if(isset($_SESSION['user'])){
        //HOMEPAGE CONSIGLIATA

    }
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
                }
            }
        }
    }

    foreach ($arrayCategorie as $value){
        array_push($arrayCategorie, $item);
        $query3="SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento
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
                <a href="prodotto.php?id=<?=$evento['ID_Evento']?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?></a>
            </div>
            <?php
        }
    }
?>


</body>
</html>














