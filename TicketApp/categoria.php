<?php
    include_once "header.php";
    require_once "DB_connection.php";
    $var=$_GET['categoria'];
    if (!empty($pdo)) {
        $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento
    from eventi
    join categoriaeventi on eventi.Categoria = categoriaeventi.ID_Categoria
    where CategoriaEventi.Descrizione_Categoria like '$var';";
        $statement = $pdo -> query($query);

        if (!$statement){
            echo "ERROR";
        }
        else{
            $eventi = $statement -> fetchAll();
        }
    }
?>
<h1><?= $var?></h1>
<?php




foreach ($eventi as $evento){
?>
<div>
    <img src="images\default.jpg">
    <a  href="prodotto.php?id=<?=$evento['ID_Evento']?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?></a>
</div>
<?php
}

include_once "footer.php";
?>
