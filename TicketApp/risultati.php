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

?>
    <div class="container my-4">
        <h1 class="mb-4">Risultati per: <?=$parola ?></h1>
<?php
    foreach ($eventi as $evento){
        ?>
        <div class="card mb-3 border border-dark">
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
?>
    </div>
<?php
}

include_once "footer.php";