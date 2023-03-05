<?php
include 'connection.php';
include 'protectIndex.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    

    if (
        isset($_POST['email']) || isset($_POST['nome'])
        || isset($_POST['senha']) || isset($_POST['confirmarSenha'])
    ) {
        if (
            strlen($_POST['email']) == 0 ||
            strlen($_POST['nome']) == 0 ||
            strlen($_POST['senha']) == 0 ||
            strlen($_POST['confirmarSenha']) == 0
        ) {
            echo <<<HTML
               <h3 class="erro">Por favor preencha todos os campos</h3>
            HTML;

        } else if ($_POST['senha'] != $_POST['confirmarSenha']) {
            echo <<<HTML
               <h3 class="erro">As senhas precisam ser identicas!</h3>
            HTML;
        } else {
            $email = $mysqli->real_escape_string($_POST['email']);
            $senha = $mysqli->real_escape_string($_POST['senha']);
            $nome = $mysqli->real_escape_string($_POST['nome']);
            $sqlquery = "SELECT * FROM USUARIO WHERE email='$email'";
            $queryResult = $mysqli->query($sqlquery) or die("Falha na execucao " . mysqli_error($mysqli));

            $quantidade = $queryResult->num_rows;

            echo $quantidade;
            if ($quantidade == 0) {

                $sql = "INSERT INTO usuario(nome, senha, email) VALUES('$nome', '$senha', '$email')";
                if (!isset($_SESSION)) {
                    session_start();
                }


               
                $insertQuery = $mysqli->query($sql) or die("Falha na execucao " . mysqli_error($mysqli));
                $queryResult = $mysqli->query($sqlquery) or die("Falha na execucao " . mysqli_error($mysqli));
                $usuario = $queryResult->fetch_assoc();
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nome'] = $usuario['nome'];
                //echo 
                header("Location: mainpage.php");
            }
            else{
                echo <<<HTML
               <h3 class="erro">Conta ja cadastrada</h3>
            HTML;
            }
        }
    }
    ?>
    <div class="wrapper-container">
        <div class="container">
            <form action="" method="POST">
                <h2>
                    Cadastre-se
                </h2>

                <input class="input" type="text" name="nome" placeholder="nome de usuário">
                <br>

                <input class="input" type="text" name="email" placeholder="email">
                <br>

                <input class="input" type="password" name="senha" placeholder="senha">
                <br>

                <input class="input" type="password" name="confirmarSenha" placeholder="confirmar senha">

                <br>
                <input class="button" type="submit">
            </form>
            <a href='login.php'>Ja tenho conta</a>
        </div>
    </div>
</body>

</html>