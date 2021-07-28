<?php
session_start();
?>

<!Doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Login</title>
</head>

<body>
    <h2>Acesse o balanço patrimonial</h2>
    <?php //mensagens de erro
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if(isset($_SESSION['msg-cadastro'])){
            echo $_SESSION['msg-cadastro'];
            unset($_SESSION['msg-cadastro']);
        }
    ?>
    <br><br>
    <form method="POST" action="validacao.php">
        <label>E-mail</label>
        <input type="text" name="login" placeholder="Digite seu e-mail"><br><br>
        
        <label>Senha</label>
        <input type="text" name="senha" placeholder="Digite sua senha"><br><br>

        <input type="submit" name="acessar" placeholder="Acessar"><br><br>

        <a href="signup.php">Cadastre-se</a>
    </form>
</body>

</html>