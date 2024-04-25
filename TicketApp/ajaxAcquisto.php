<?php
require "Database\DB_connection.php";
session_start();
if (isset($_SESSION["user"])) {
    $query = "DELETE FROM Carrello WHERE Utente = ? && Evento = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$_SESSION["user"], $_GET["Evento"]]);

    }