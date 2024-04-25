<?php
    //DA METTERE NELLA PAGINA CARRELLO COSI' L'UTENTE DEVE LOGGARSI PRIMA DI ACQUISTARE
    /*session_start();
    if(!isset($_SESSION[]['user'])){
        header("Location: login.php");
    }*/
?>

<?php
    session_start();
    if(isset($_SESSION['user'])){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
<div class="container text-center w-25">
    <h2>Login</h2>
    <form method="post" action="" autocomplete="off">
        <div class="form-group m-4">
            <input type="text" class="form-control" name="username" id="username" value="" placeholder="Username o Email">
        </div>
        <div class="form-group m-4">
            <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password">
        <div class="form-btn m-2">
            <input type="submit" class="btn btn-primary" name="submit" value="Login">
        </div>
    </form>
    <p>Non hai ancora un account? <a href="registration.php">Registrati</a></p>
</div>
</body>
</html>

<?php
    require_once 'DB_connection.php';

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($pdo)){
            $parameters['username'] = $username;
            $parameters['email'] = $username;

            $query = "SELECT Username, Email, Password FROM Utenti WHERE Username LIKE :username OR Email LIKE :email;";
            $statement = $pdo -> prepare($query);
            $result = $statement -> execute($parameters);

            if(!$statement){
                die("Qualcosa è andato storto");
            }
            else{
                $userData = $statement -> fetchAll();
                if(count($userData) > 0){
                    if(password_verify($password, $userData[0]['Password'])){
                        session_start();
                        $_SESSION['user'] = "yes";
                        $_SESSION['username'] = $userData[0]['Username'];
                        $_SESSION['email'] = $userData[0]['Email'];
                        header("Location: index.php");
                        die();
                    }
                    else{
                        echo "<div class='container text-center alert alert-danger'>Password non corretta</div>";
                    }
                }
                else{
                    echo "<div class='container text-center alert alert-danger'>Username non corretto</div>";
                }
            }
        }
    }
?>