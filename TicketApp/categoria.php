<?php
include_once "header.php";
require_once "Database\DB_connection.php";
$var=$_GET['categoria'];
?>

<h1><?= $var?></h1>
<form action="" method="GET" class="row g-3 align-items-center">
    <input type="hidden" name="categoria" value="<?= htmlspecialchars($var) ?>">
    <div class="col-auto">
        <label for="sort" class="col-form-label">Ordina per:</label>
    </div>
    <div class="col-auto">
        <select name="sort" id="sort" class="form-select w-auto">
            <option value="normale" selected disabled>---</option>
            <option value="nomeAsc" >Ordine Alfabetico Crescente &#xf15d;</option>
            <option value="nomeDesc">Ordine Alfabetico Decrescente &#xf881;</option>
            <option value="prezzoAsc">Prezzo Crescente &#xf062;</option>
            <option value="prezzoDesc">Prezzo Decrescente &#xf063;</option>
        </select>
    </div>
    <div class="col-auto">
        <input type="submit" value="Ordina" class="btn btn-primary w-auto">
    </div>
</form>

<?php

if(isset($_GET['sort'])){
    $scelta=$_GET['sort'];
    switch ($scelta){
        case 'nomeAsc':
            $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine
                        from eventi
                                 join categoriaeventi on eventi.Categoria = categoriaeventi.ID_Categoria
                        where CategoriaEventi.Descrizione_Categoria like '$var'
                        order by eventi.Descrizione;";
            $statement = $pdo -> query($query);
            $eventiOrdinati = $statement -> fetchAll();
            break;
        case 'nomeDesc':
            $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine
                        from eventi
                                 join categoriaeventi on eventi.Categoria = categoriaeventi.ID_Categoria
                        where CategoriaEventi.Descrizione_Categoria like '$var'
                        order by eventi.Descrizione desc;";
            $statement = $pdo -> query($query);
            $eventiOrdinati = $statement -> fetchAll();
            break;
        case 'prezzoAsc':
            $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine
                        from eventi
                        join categoriaeventi on eventi.Categoria = categoriaeventi.ID_Categoria
                        where CategoriaEventi.Descrizione_Categoria like '$var'
                        order by eventi.Prezzo;";
            $statement = $pdo -> query($query);
            $eventiOrdinati = $statement -> fetchAll();
            break;

        case 'prezzoDesc':
            $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine
                        from eventi
                        join categoriaeventi on eventi.Categoria = categoriaeventi.ID_Categoria
                        where CategoriaEventi.Descrizione_Categoria like '$var'
                        order by eventi.Prezzo desc ;";
            $statement = $pdo -> query($query);
            $eventiOrdinati = $statement -> fetchAll();
            break;

    }

    foreach ($eventiOrdinati as $evento){
        ?>
        <div>
            <img class="imgCategoria" src="<?= $evento['Immagine'] ?>">
            <a  href="prodotto.php?id=<?=$evento['ID_Evento']?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?>€</a>
        </div>
        <?php
    }

}

if (!empty($pdo)) {
    $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine
        from eventi
        join categoriaeventi on eventi.Categoria = categoriaeventi.ID_Categoria
        where CategoriaEventi.Descrizione_Categoria like '$var';";
    $statement = $pdo -> query($query);

    if (!$statement){
        echo "ERROR";
    }
    else{
        $eventi = $statement -> fetchAll();
        foreach ($eventi as $evento){
            ?>
            <div>
                <img class="imgCategoria" src="<?= $evento['Immagine'] ?>">
                <a  href="prodotto.php?id=<?=$evento['ID_Evento']?>"><?= $evento['Descrizione'] . ' ' .  $evento['Prezzo']?>€</a>
            </div>
            <?php
        }
    }
}

include_once "footer.php";
?>
