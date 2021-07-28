<?php
    session_start();
    include_once("conexao.php");

    $btnPassivo = filter_input(INPUT_POST, 'btnPassivo', FILTER_SANITIZE_STRING);

    if($btnPassivo){ //adiciona um passivo ao banco
        $descricao = filter_input(INPUT_POST, 'descricao-passivo', FILTER_SANITIZE_STRING);
        $passivo = filter_input(INPUT_POST, 'passivo', FILTER_SANITIZE_STRING);

        if( (!empty($passivo) AND !empty($descricao)) ){ //verifica se não falta nem valor nem descricao
            $dados_crus = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $erro = false;

            $dados_filt = array_map('strip_tags', $dados_crus);
            $dados = array_map('trim', $dados_filt);

            if(!is_numeric($dados['passivo'])){
                $erro = true;
                $_SESSION['bp'] = "O valor do passivo deve ser um número";
            }
        }
        else{
            $_SESSION['bp'] = "Preencha todos os campos!";
            header("Location: wallet.php");
        }

        if(!$erro){ //insere os dados no banco se estiver tudo ok
            $result_passivo = "INSERT INTO balanco (description, value, owner, type) VALUES (
                '".$dados['descricao-passivo']."',
                '".$dados['passivo']."',
                '".$_SESSION['uid']."',
                '1'
            )";

            $resultado_passivo = mysqli_query($conn, $result_passivo);

            if(mysqli_insert_id($conn)){
                $_SESSION['bp'] = "Passivo cadastrado com sucesso!";
                header("Location: wallet.php");
            }
        }
    }