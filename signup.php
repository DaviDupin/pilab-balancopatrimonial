<?php
    session_start();
    ob_start();
    $btnCadastro = filter_input(INPUT_POST, 'btnCadastro', FILTER_SANITIZE_STRING);
    if($btnCadastro){
        include_once 'conexao.php';
        $dados_crus = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        $erro = false;

        $dados_filt = array_map('strip_tags', $dados_crus);
        $dados = array_map('trim', $dados_filt);

        if(in_array('',$dados)){
            $erro = true;
            $_SESSION['msg'] = "Preencha todos os campos";
        }
        elseif( (strlen($dados['senha'])) < 8){
            $erro = true;
            $_SESSION['msg'] = "A senha deve ter no mínimo 8 caracteres";
        }
        elseif(stristr($dados['senha'], "'")){
            $erro = true;
            $_SESSION['msg'] = "Caracter (') inválido";
        }
        else{
            $result_usuario = "SELECT uid FROM usuarios WHERE email='".$dados['login']."' ";
            $resultado_usuario = mysqli_query($conn, $result_usuario);
            if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
                $erro = true;
                $_SESSION['msg'] = "E-mail já cadastrado";
            }
        }

        if(!$erro){    
            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

            $result_usuario = "INSERT INTO usuarios (name, email, password) VALUES (
                                '".$dados['nome']."',
                                '".$dados['login']."',
                                '".$dados['senha']."'
            )";

            $resultado_usuario = mysqli_query($conn, $result_usuario);

            if(mysqli_insert_id($conn)){
                $_SESSION['msg-cadastro'] = "Cadastrado com sucesso!";
                header("Location: login.php");
            }
            else{
                $_SESSION['msg'] = "Erro de cadastro";
            }
        }
    }
?>

<!Doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastro</title>
</head>

<body>
    <h2>Cadastre-se</h2>
    <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    ?>
    <br>
    <form method="POST" action="">
        <label>Nome</label>
        <input type="text" name="nome" placeholder="Digite seu nome"><br><br>

        <label>E-mail</label>
        <input type="text" name="login" placeholder="Digite seu e-mail"><br><br>

        <label>Senha</label>
        <input type="text" name="senha" placeholder="Digite sua senha"><br><br>

        <input type="submit" name="btnCadastro" placeholder="Cadastre-se"><br><br>

        <a href="login.php">Login</a>
    </form>
</body>

</html>