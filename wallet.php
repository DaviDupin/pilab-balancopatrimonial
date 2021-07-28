<?php
    session_start();
    include_once("conexao.php");
    echo "Bem vindo, " .$_SESSION['name']. "! Este é o seu balanço patrimonial<br>";
    echo "<a href='end.php'>Sair</a>";
?>

<!Doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Wallet</title>
</head>

<body>
    <h2>Balanço Patrimonial Simplificado</h2>

    <?php
        if(isset($_SESSION['bp'])){
            echo $_SESSION['bp'];
            unset($_SESSION['bp']);
        }
    ?>
    
    <br><br>
    <form method="POST" action="deposit.php">
        <label>Adicione um ativo</label><br><br>
        <input type="text" name="descricao-ativo" placeholder="Digite a descrição do ativo"><br><br>
        <input type="text" name="ativo" placeholder="Digite o valor do ativo"><br><br>
        <input type="submit" name="btnAtivo" placeholder="Adicionar"><br><br>
    </form>

    <form method="POST" action="withdraw.php">
        <label>Adicione um passivo</label><br><br>
        <input type="text" name="descricao-passivo" placeholder="Digite a descrição do passivo"><br><br>
        <input type="text" name="passivo" placeholder="Digite o valor do passivo"><br><br>
        <input type="submit" name="btnPassivo" placeholder="Adicionar"><br><br>
    </form>

    <h3>Ativos - Total:
        <?php //busca a soma de todas as ocorrencias de ativos (type2) pertencentes ao usuario logado
            $tot_ativos = "SELECT SUM(value) AS value_sum FROM balanco WHERE owner='".$_SESSION['uid']."' AND type='2' ";
            $total_ativos = mysqli_query($conn, $tot_ativos);
            $row_ativos = mysqli_fetch_assoc($total_ativos);
            $soma_ativos = $row_ativos['value_sum'];
            echo "{$soma_ativos}";
        ?>
    </h3>
    <ul>
        <?php //detalhamento dos valores e descricao
            $parc_ativos = "SELECT description,value FROM balanco WHERE owner='".$_SESSION['uid']."' AND type='2' ";
            $parcial_ativos = mysqli_query($conn, $parc_ativos);
            while($div_ativos = mysqli_fetch_array($parcial_ativos, MYSQLI_ASSOC)){
                echo "<li>" .$div_ativos['description']." - R$: " .$div_ativos['value']. "</li>";
                echo "<br>";
            }
        ?>
    <br>
    </ul>

    <h3>Passivos - Total:
        <?php //busca a soma de todas as ocorrencias de passivos (type1) pertencentes ao usuario logado
            $tot_passivos = "SELECT SUM(value) AS value_sum FROM balanco WHERE owner='".$_SESSION['uid']."' AND type='1' ";
            $total_passivos = mysqli_query($conn, $tot_passivos);
            $row_passivos = mysqli_fetch_assoc($total_passivos);
            $soma_passivos = $row_passivos['value_sum'];
            echo "{$soma_passivos}";
        ?>
    </h3>
    <ul>
        <?php //detalhamento dos valores e descricao
            $parc_ativos = "SELECT description,value FROM balanco WHERE owner='".$_SESSION['uid']."' AND type='1' ";
            $parcial_ativos = mysqli_query($conn, $parc_ativos);
            while($div_ativos = mysqli_fetch_array($parcial_ativos, MYSQLI_ASSOC)){
                echo "<li>" .$div_ativos['description']." - R$: " .$div_ativos['value']. "</li>";
                echo "<br>";
            }
        ?>
    <br>
    </ul>

    <h3>Balanço Patrimonial - Total:
        <?php
            $valor_balanco = $soma_ativos - $soma_passivos;
            echo "{$valor_balanco}";
        ?>
    </h3>
    
</body>

</html>