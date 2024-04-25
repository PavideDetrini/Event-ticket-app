<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Cambia Password</title>
</head>
<body>
<div class="container text-center w-25 mx-auto">
    <h2>Cambia Password</h2>
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
            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password">
        </div>
        <div class="form-group m-4">
            <input type="password" class="form-control" name="newPassword" id="newPassword" value="" placeholder="Nuova Password">
        </div>
        <div class="form-group m-4">
            <input type="password" class="form-control" name="confirm_newPassword" id="confirm_newPassword" value="" placeholder="Conferma Nuova Password">
        </div>
        <div class="form-btn m-2">
            <input type="submit" class="btn btn-primary" name="submit" value="Cambia Password">
        </div>
    </form>

    <?php
    require_once 'Database\DB_connection.php';

    if(isset($_POST['submit'])){
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $newPassword = $_POST['newPassword'];
        $confirm_newPassword = $_POST['confirm_newPassword'];

        $errors = array();
        if(empty($nome) || empty($cognome) || empty($email) || empty($password) || empty($newPassword) || empty($confirm_newPassword)){
            array_push($errors, "Tutti i campi sono richiesti");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email non valida");
        }
        if(strlen($password) < 8){
            array_push($errors, "La password deve contenere almeno 8 caratteri");
        }
        if($newPassword === $password){
            array_push($errors, "La nuova password deve essere diversa da quella vecchia");
        }
        if($newPassword !== $confirm_newPassword){
            array_push($errors, "Le nuove password non corrispondono");
        }

        $existUser = $pdo -> prepare("SELECT * FROM Utenti WHERE Email LIKE :email;");
        $existUser->execute(['email' => $email]);
        if($existUser->rowCount() <= 0){
            array_push($errors, "Account non esistente");
        }

        $userPassword = $pdo->prepare("SELECT * FROM Utenti WHERE Email LIKE :email;");
        $userPassword->execute(['email' => $email]);
        $user = $userPassword -> fetchAll();

        if(!$user || !password_verify($password, $user[0]['Password'])){
            array_push($errors, "La vecchia password non è corretta");
        }


        if(count($errors) > 0){
            foreach ($errors as $value){
                echo "<div class='container text-center alert alert-danger'>$value</div>";
            }
        }
        else{

            $parameters['email'] = $email;
            $parameters['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = "UPDATE Utenti SET Password = :password WHERE Email LIKE :email;";
            $statement = $pdo -> prepare($update);
            $result = $statement -> execute($parameters);

            if ($result){
                echo "<div class='container text-center alert alert-success'>Password cambiata con successo</div>";
                echo "<a class='btn btn-primary' href='account.php'>Torna all'account</a>";
            }
            else{
                echo "<div class='container text-center alert alert-danger'>Si è verificato un errore durante l'aggiornamento della password</div>";
            }
        }
    }
    ?>
</div>
</body>
</html>

