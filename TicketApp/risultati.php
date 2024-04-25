<?php
    include_once "header.php";
    require_once "Database\DB_connection.php";

    if(isset($_GET['search'])){
        $parola=$_GET['search'];


        $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento
                            from eventi
                                     join categoriaeventi on eventi.Categoria = categoriaeventi.ID_Categoria
                            where Eventi.Descrizione like '%$parola%';";
        $statement = $pdo -> query($query);
        $eventi = $statement -> fetchAll();


        foreach ($eventi as $evento){
            ?>
            <div>
                <img src="images\default.jpg">
                <a  href="prodotto.php?id=<?=$evento['ID_Evento']?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?>€</a>
            </div>
            <?php
        }
    }

    include_once "footer.php";