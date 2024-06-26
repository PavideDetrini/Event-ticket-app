<?php
require_once "Database\DB_connection.php";

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


<footer class="text-center custom-footer sticky">
    <section>
        <div class="container text-start mt-5">
            <div class="row mt-2">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4 mt-0">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon me-2"></div>
                        <h6 class="text-uppercase fw-bold mb-0">
                            WaveTickets
                        </h6>
                    </div>
                    <p>
                        Scatena l'onda di divertimento con WaveTickets!<br>
                        Scopri una vasta gamma di attività, concerti, mostre e molto altro ancora, tutto a portata di clic.<br>
                        Affidati a noi per trasformare ogni momento in un'occasione memorabile.
                    </p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4 mt-1">
                    <h6 class="text-uppercase fw-bold mb-4">
                        Prodotti
                    </h6>

                    <?php
                    foreach ($categorie as $row){
                        foreach ($row as $descrizione){
                            ?>
                            <p>
                                <a href="categoria.php?categoria=<?= $descrizione?>" class="nav-link"><?= $descrizione?></a>
                            </p>

                            <?php
                        }
                    }
                    ?>
                </div>

                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4 mt-1">
                    <h6 class="text-uppercase fw-bold mb-4">
                        Link utili
                    </h6>
                    <p>
                        <a href="help.php" class="text-reset noDecoration">Supporto</a>
                    </p>
                    <p>
                        <a href="privacy.php" class="text-reset noDecoration">Privacy</a>
                    </p>
                    <p>
                        <a href="https://github.com/PavideDetrini/Event-ticket-app" class="text-reset noDecoration">Versioni</a>
                    </p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4 mt-1">
                    <h6 class="text-uppercase fw-bold mb-4">Contatti</h6>
                    <p><i class="bi bi-house-door-fill me-3"></i>New York, NY 10012, US</p>
                    <p><i class="bi bi-envelope-fill me-3"></i>WaveTickets@isisfacchinetti.edu.it</p>
                    <p><i class="bi bi-telephone-fill me-3"></i>+39 012-345-6789</p>
                    <p><i class="bi bi-printer-fill me-3"></i>+39 987-654-3210</p>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center p-4 social-div">
        <i class="bi bi-facebook"></i>
        <i class="bi bi-instagram"></i>
        <i class="bi bi-tiktok"></i>
        <i class="bi bi-twitter-x"></i>
        <i class="bi bi-linkedin"></i>
        <i class="bi bi-youtube"></i>
    </div>
</footer>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('.owl-carousel').owlCarousel({
        margin: 10,
        loop: true,
        responsiveClass:true,
        nav: true,
        navText: [
            "<i class='bi bi-arrow-left-circle-fill'></i>",
            "<i class='bi bi-arrow-right-circle-fill'></i>"
        ],
        dots: false,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:2,
                nav:true
            },
            1000:{
                items:3,
                nav:true,
                loop:true
            }
        }
    });
</script>
</body>
</html>
