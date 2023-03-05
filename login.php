<?php
include 'connection.php';
include 'protectIndex.php';
if (isset($_POST['email']) || isset($_POST['senha'])) {
    if (strlen($_POST['email']) == 0 || strlen($_POST['senha']) == 0) {
        echo <<<HTML
               <h3 class="erro">Por favor preencha todos os campos!</h3>
            HTML;
    }
    else{
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        $sqlquery = "SELECT * FROM USUARIO WHERE email='$email' AND senha='$senha'";
        $queryResult = $mysqli->query($sqlquery) or die("Falha na execucao " . mysqli_error($mysqli));
        // sqlinsert = 
        $quantidade = $queryResult->num_rows;
       
        if($quantidade == 1){
          
                $usuario = $queryResult->fetch_assoc();

                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nome'] = $usuario['nome'];
                echo $_SESSION['nome'];
                header("Location: mainpage.php");
        }
        else{
            echo <<<HTML
               <h3 class="erro">Usuario nao cadastrado!</h3>
            HTML;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper-container">
        <div class="container">
            <form action="" method="POST">
                <h2>
                    Logue-se
                </h2>

                <input class="input" type="text" name="email" placeholder="email">
                <br>

                <input class="input" type="text" name="senha" placeholder="senha">
                <br>

                <input class="button" type="submit">
            </form>
            <a href='index.php'>Nao tenho conta</a>
        </div>
    </div>
</body>

</html>