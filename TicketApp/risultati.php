<?php
include_once "header.php";
require_once "Database\DB_connection.php";

if(isset($_GET['search'])){
    $parola=$_GET['search'];


    $query = "SELECT * FROM Eventi
                  JOIN CategoriaEventi ON Eventi.Categoria = CategoriaEventi.ID_Categoria
                  JOIN Luoghi ON Eventi.Luogo = Luoghi.ID_Luogo
                  WHERE Eventi.Descrizione LIKE '%$parola%' 
                  OR Luoghi.Città LIKE '%$parola%' 
                  OR Luoghi.Nome LIKE '%$parola%'
                  OR CategoriaEventi.Descrizione_Categoria LIKE '%$parola%';";
    $statement = $pdo -> query($query);
    $eventi = $statement -> fetchAll();


    foreach ($eventi as $evento){
        ?>
        <div>
            <img src="<?= $evento['Immagine'] ?>">
            <a  href="prodotto.php?id=<?=$evento['ID_Evento']?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?>€</a>
        </div>
        <?php
    }
}

include_once "footer.php";