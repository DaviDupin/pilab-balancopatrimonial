<?php
    session_start();
    include_once("conexao.php");

    $btnAtivo = filter_input(INPUT_POST, 'btnAtivo', FILTER_SANITIZE_STRING);

    if($btnAtivo){ //adiciona um ativo ao banco
        $descricao = filter_input(INPUT_POST, 'descricao-ativo', FILTER_SANITIZE_STRING);
        $ativo = filter_input(INPUT_POST, 'ativo', FILTER_SANITIZE_STRING);

        if( (!empty($ativo) AND !empty($descricao)) ){ //verifica se não falta nem valor nem descricao
            $dados_crus = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $erro = false;

            $dados_filt = array_map('strip_tags', $dados_crus);
            $dados = array_map('trim', $dados_filt);

            if(!is_numeric($dados['ativo'])){
                $erro = true;
                $_SESSION['bp'] = "O valor do ativo deve ser um número";
            }
        }
        else{
            $_SESSION['bp'] = "Preencha todos os campos!";
            header("Location: wallet.php");
        }

        if(!$erro){ //insere os dados no banco se estiver tudo ok
            $result_ativo = "INSERT INTO balanco (description, value, owner, type) VALUES (
                '".$dados['descricao-ativo']."',
                '".$dados['ativo']."',
                '".$_SESSION['uid']."',
                '2'
            )";

            $resultado_ativo = mysqli_query($conn, $result_ativo);

            if(mysqli_insert_id($conn)){
                $_SESSION['bp'] = "Ativo cadastrado com sucesso!";
                header("Location: wallet.php");
            }
        }
    }