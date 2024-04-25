<?php
    session_start();
    if(isset($_SESSION['user'])){
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en" class="html-form">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="checkPassword.js" defer></script>
    <title>Registrazione</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body class="body-form">
    <section>
        <div class="container-form text-center w-50">
            <h2>Registrazione</h2>
            <form method="post" action="" autocomplete="off">
                <div class="form-group m-4">
                    <input type="text" class="form-control" name="nome" id="nome" value="" placeholder="Nome">
                </div>
                <div class="form-group m-4">
                    <input type="text" class="form-control" name="cognome" id="cognome" value="" placeholder="Cognome">
                </div>
                <div class="form-group m-4">
                    <input type="text" class="form-control" name="username" id="username" value="" placeholder="Username">
                </div>
                <div class="form-group m-4">
                    <input type="email" class="form-control" name="email" id="email" value="" placeholder="Email">
                </div>
                <div class="form-group m-4">
                    <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password">
                </div>
                <div class="form-group m-4">
                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" placeholder="Conferma Password">
                </div>
                <div class="form-btn m-2">
                    <input type="submit" class="btn btn-outline-primary" name="submit" value="Registrati">
                </div>
            </form>
            <p>Hai già un account? <a href="login.php">Login</a></p>
        </div>

<?php
    require_once 'Database\DB_connection.php';

    if(isset($_POST['submit'])){
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = array();
        if(empty($nome) OR empty($cognome) OR empty($username) OR empty($email) OR empty($password) OR empty($confirm_password)){
            array_push($errors, "Tutti i campi sono richiesti");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email non valida");
        }
        if(!is_string($password) || strlen($password) < 8){
            array_push($errors, "La password deve contenere almeno 8 caratteri");
        }

        $duplicate = $pdo -> query("SELECT * FROM Utenti WHERE Username = '$username' OR Email = '$email';");
        if($duplicate -> rowCount() > 0){
            array_push($errors, "Username e email già esistenti");
        }
        if($password !== $confirm_password){
            array_push($errors, "Le passwords non corrispondono");
        }

        if(count($errors) > 0){
            foreach ($errors as $value){
                echo "<div class='container text-center w-25 alert alert-danger'>$value</div>";
            }
        }
        else{
            if(!empty($pdo)){
                $parameters['username'] = $username;
                $parameters['password'] = password_hash($password, PASSWORD_DEFAULT);
                $parameters['nome'] = $nome;
                $parameters['cognome'] = $cognome;
                $parameters['email'] = $email;
                $query = "INSERT INTO Utenti (Username, Password, Nome, Cognome, Email) VALUES (:username, :password, :nome, :cognome, :email);";
                $statement = $pdo -> prepare($query);
                $result = $statement -> execute($parameters);
                if (!$statement){
                    die("Qualcosa è andato storto");
                }
                else{
                    echo "<div class='container text-center w-25 alert alert-success'>Registrazione completata</div>";
                    header("Location: login.php");
                    exit();
                }
            }
        }
    }
?>
        <div class='container text-center w-25 alert alert-danger' id="error"></div>
    </section>
</body>
</html>

