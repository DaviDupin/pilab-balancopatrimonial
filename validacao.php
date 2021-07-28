<?php
session_start();
include_once("conexao.php");

$acessar = filter_input(INPUT_POST, 'acessar', FILTER_SANITIZE_STRING);

if($acessar){ //quando o gatilho (botão) de acessar for ativado
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    
    if( (!empty($login)) AND (!empty($senha)) ){ //verifica se ambos os campos estão preenchidos
        $result_usuario = "SELECT uid,name,email,password FROM usuarios WHERE email='$login' LIMIT 1";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        
        if($resultado_usuario){ //entra se a conexão for bem sucedida
            $row_usuario = mysqli_fetch_assoc($resultado_usuario);

            if( password_verify($senha, $row_usuario['password']) ){ //senha correta
                $_SESSION['uid'] = $row_usuario['uid'];
                $_SESSION['name'] = $row_usuario['name'];
                header("Location: wallet.php");
            }
            else{ //senha errada
                $_SESSION['msg'] = "Login ou senha incorreto";
                header("Location: login.php");
            }
        }
        else{ //não recuperou informações do BD
            $_SESSION['msg'] = "Erro de conexão com o BD";
            header("Location: login.php");
        }
    }
    else{ //cai aqui se login ou senha estiverem em branco
        $_SESSION['msg'] = "Login ou senha em branco";
        header("Location: login.php");
    }
}
else{ //cai aqui em caso de tentar acessar página restrita sem estar logado
    $_SESSION['msg'] = "Página não encontrada";
    header("Location: login.php");
}
