<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supporto Tecnico</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-help">
    <h1>Supporto Tecnico</h1>
    <p>Benvenuto nel nostro servizio di supporto tecnico. Compila il modulo sottostante per inviarci un messaggio.</p>
    <div class="contact-form">
        <form action="" method="post" enctype="text/plain">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="name">Cognome:</label>
                <input type="text" id="cognome" name="cognome" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="messaggio">Messaggio:</label>
                <textarea id="messaggio" name="messaggio" required></textarea>
            </div>
            <div class="form-group">
                <input name="submit" type="submit" value="Invia">
            </div>
        </form>
    </div>
</div>
</body>
</html>




<?php
require_once 'Database\DB_connection.php';

if(isset($_POST['submit'])){
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $messaggio=$_POST['messaggio'];


    $errors = array();
    if(empty($nome) OR empty($cognome) OR empty($nome) OR empty($cognome) OR empty($email) OR empty($messaggio)){
        array_push($errors, "Tutti i campi sono richiesti");
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Email non valida");
    }

    if(count($errors) > 0){
        foreach ($errors as $value){
            echo "<div class='container text-center w-25 alert alert-danger'>$value</div>";
        }
    }
    else{
        if(!empty($pdo)){
            $parameters['nome'] = $nome;
            $parameters['cognome'] = $cognome;
            $parameters['email'] = $email;
            $parameters['messaggio']=$messaggio;
            $query = "INSERT INTO Supporto ( Nome, Cognome, Email,Messaggio) VALUES ( :nome, :cognome, :email,:messaggio);";
            $statement = $pdo -> prepare($query);
            $result = $statement -> execute($parameters);
            if (!$statement){
                die("Qualcosa è andato storto");
            }
            else{
                echo $statement ->rowCount();
            }
        }
    }
}
?>













