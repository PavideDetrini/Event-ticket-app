<?php
include_once "header.php";
require_once "Database/DB_connection.php";
$var = htmlspecialchars($_GET['categoria']);
?>

<div class="container my-4">
    <h1 class="mb-4"><?= $var ?></h1>
    <form action="" method="GET" class="row g-3 align-items-center mb-4">
        <input type="hidden" name="categoria" value="<?= htmlspecialchars($var) ?>">
        <div class="col-auto">
            <label for="sort" class="col-form-label">Ordina per:</label>
        </div>
        <div class="col-auto">
            <select name="sort" id="sort" class="form-select w-auto">
                <option value="normale" selected disabled>---</option>
                <option value="nomeAsc">Ordine Alfabetico Crescente &#xf15d;</option>
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
    if (isset($_GET['sort'])) {
        $scelta = $_GET['sort'];
        $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine
                  FROM eventi
                  JOIN categoriaeventi ON eventi.Categoria = categoriaeventi.ID_Categoria
                  WHERE CategoriaEventi.Descrizione_Categoria LIKE '$var'";

        switch ($scelta) {
            case 'nomeAsc':
                $query .= " ORDER BY eventi.Descrizione;";
                break;
            case 'nomeDesc':
                $query .= " ORDER BY eventi.Descrizione DESC;";
                break;
            case 'prezzoAsc':
                $query .= " ORDER BY eventi.Prezzo;";
                break;
            case 'prezzoDesc':
                $query .= " ORDER BY eventi.Prezzo DESC;";
                break;
        }

        $statement = $pdo->query($query);
        $eventiOrdinati = $statement->fetchAll();

        foreach ($eventiOrdinati as $evento) {
            ?>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?= $evento['Immagine'] ?>" class="img-fluid rounded-start fixed-image" alt="<?= $evento['Descrizione'] ?>">
                    </div>
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="card-body d-flex justify-content-between align-items-center w-100">
                            <div>
                                <h5 class="card-title"><?= $evento['Descrizione'] ?></h5>
                                <p class="card-text"><?= $evento['Prezzo'] ?>€</p>
                            </div>
                            <div class="btn-container">
                                <a href="prodotto.php?id=<?= $evento['ID_Evento'] ?>" class="btn btn-primary">Vedi Dettagli</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        $query = "SELECT Eventi.Descrizione, Eventi.Prezzo, Eventi.ID_Evento, Eventi.Immagine
                  FROM eventi
                  JOIN categoriaeventi ON eventi.Categoria = categoriaeventi.ID_Categoria
                  WHERE CategoriaEventi.Descrizione_Categoria LIKE '$var';";
        $statement = $pdo->query($query);

        if ($statement) {
            $eventi = $statement->fetchAll();
            foreach ($eventi as $evento) {
                ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?= $evento['Immagine'] ?>" class="img-fluid rounded-start imgCategoria" alt="<?= $evento['Descrizione'] ?>">
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="card-body d-flex justify-content-between align-items-center w-100">
                                <div>
                                    <h5 class="card-title"><?= $evento['Descrizione'] ?></h5>
                                    <p class="card-text"><?= $evento['Prezzo'] ?>€</p>
                                </div>
                                <div class="btn-container">
                                    <a href="prodotto.php?id=<?= $evento['ID_Evento'] ?>" class="btn btn-primary">Vedi Dettagli</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='alert alert-danger'>Errore nel recupero dei dati.</div>";
        }
    }
    ?>

</div>

<?php include_once "footer.php"; ?>
