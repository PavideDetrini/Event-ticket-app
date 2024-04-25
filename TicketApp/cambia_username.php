<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location: index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en" class="html-form">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Cambia Username</title>
</head>
<body class="body-form">
    <section>
        <div class="container-form text-center w-25 mx-auto">
            <h2>Cambia Username</h2>
            <form method="post" action="" autocomplete="off">
                <div class="form-group m-4">
                    <input type="text" class="form-control" name="nome" id="nome" value="" placeholder="Nome">
                </div>
                <div class="form-group m-4">
                    <input type="text" class="form-control" name="cognome" id="cognome" value="" placeholder="Cognome">
                </div>
                <div class="form-group m-4">
                    <input type="email" class="form-control" name="email" id="email" value="" placeholder="Email">
                </div>
                <div class="form-group m-4">
                    <input type="text" class="form-control" name="username" id="username" value="" placeholder="Nuovo Username">
                </div>
                <div class="form-btn m-2">
                    <input type="submit" class="btn btn-primary" name="submit" value="Cambia Username">
                </div>
            </form>
        </div>

<?php
    require_once 'Database\DB_connection.php';

if(isset($_POST['submit'])){
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $errors = array();
    if(empty($nome) || empty($cognome) || empty($username) || empty($email)){
        array_push($errors, "Tutti i campi sono richiesti");
    }
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Email non valida");
    }

    $existEmail = $pdo -> prepare("SELECT * FROM Utenti WHERE Email LIKE :email");
    $existEmail->execute(['email' => $email]);
    if($existEmail->rowCount() <= 0){
        array_push($errors, "Account non esistente");
    }

    $duplicate = $pdo -> prepare("SELECT * FROM Utenti WHERE Username LIKE :username");
    $duplicate->execute(['username' => $username]);
    if($duplicate->rowCount() > 0){
        array_push($errors, "Username già in uso");
    }

    if(count($errors) > 0){
        foreach ($errors as $value){
            echo "<div class='container text-center alert alert-danger w-25'>$value</div>";
        }
    }
    else{

        $parameters['username'] = $username;
        $parameters['email'] = $email;
        $update = "UPDATE Utenti SET Username = :username WHERE Email = :email";
        $statement = $pdo->prepare($update);
        $result = $statement->execute($parameters);

        if ($result){
            echo "<div class='container text-center alert alert-success w-25'>Username cambiato con successo</div>";
            echo "<div class='text-center'>";
            echo "<a class='btn btn-primary' href='account.php'>Torna all'account</a>";
            echo "</div>";
        }
        else{
            echo "<div class='container text-center alert alert-danger w-25'>Si è verificato un errore durante l'aggiornamento dell'username</div>";
        }
    }
}
?>
    </section>
</body>
</html>
