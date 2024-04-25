<?php
//DA METTERE NELLA PAGINA CARRELLO COSI' L'UTENTE DEVE LOGGARSI PRIMA DI ACQUISTARE
/*session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}*/
?>

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
    <title>Login</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body class="body-form">
<section>
    <div class="container-form text-center w-50">
        <h2>Login</h2>
        <form method="post" action="" autocomplete="off">
            <div class="form-group m-4">
                <input type="text" class="form-control" name="username" id="username" value="" placeholder="Username o Email">
            </div>
            <div class="form-group m-4">
                <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password">
            </div>
            <div class="form-btn m-2">
                <input type="submit" class="btn btn-outline-primary" name="submit" value="Login">
            </div>
        </form>
        <p>Non hai ancora un account? <a href="registration.php">Registrati</a></p>
    </div>
</section>
</body>
</html>

<?php
require_once 'Database/DB_connection.php';

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($pdo)){
        $parameters = [
            'username' => $username,
            'email' => $username
        ];

        $query = "SELECT * FROM Utenti WHERE Username LIKE :username OR Email LIKE :email;";
        $statement = $pdo->prepare($query);
        $result = $statement->execute($parameters);

        if(!$statement){
            die("Qualcosa è andato storto");
        } else {
            $userData = $statement->fetchAll();
            if(count($userData) > 0){
                if(password_verify($password, $userData[0]['Password'])){
                    session_start();
                    $_SESSION['user'] = $userData[0]['ID_Utente'];
                    if(isset($_SESSION["NotLog"])){
                        foreach ($_SESSION["NotLog"] as $item) {
                            try {
                                $queryInsert = "INSERT INTO Carrello(Utente, Evento) VALUE (?, ?)";
                                $statement2 = $pdo->prepare($queryInsert);
                                $statement2->execute([$_SESSION["user"], $item]);
                            }catch (PDOException $Exception){
                            }
                        }
                    }
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<div class='container text-center w-25 alert alert-danger'>Password non corretta</div>";
                }
            } else {
                echo "<div class='container text-center w-25 alert alert-danger'>Username non corretto</div>";
            }
        }
    }
}
?>
