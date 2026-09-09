<?php include "header.php" ?>

<?php

    //1ª Parte: Prepara a QUERY e Exibe o TOTAL de registros
    echo "<h3 class='text-center'>Lista de USUÁRIOS cadastrados no sistema:</h3>";

    //Query para listar TODOS os registros da tabela Usuarios
    $listarUsuarios = "SELECT * FROM Usuarios";

    include "conexaoBD.php"; //Inclui o arquivo de conexão com o Banco de Dados
    //A função mysqli_query executa a QUERY no Banco de Dados
    //A função die encerra o carregamento da página;
    $res           = mysqli_query($conn, $listarUsuarios) or die("Erro ao tentar listar Usuários!");
    $totalUsuarios = mysqli_num_rows($res); //A função mysqli_num_rows retorna a quantidade de registros encontrados pela QUERY

    echo "<div class='alert alert-info text-center'>Há <strong>$totalUsuarios</strong> usuários cadastrados no sistema!</div>";

    //2ª Parte: Exibe o cabeçalho da tabela
    echo "
        <table class='table'>
            <thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>FOTO</th>
                    <th>NOME</th>
                    <th>DATA DE NASCIMENTO</th>
                    <th>CIDADE</th>
                    <th>EMAIL</th>
                    <th>NIVEL</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    ";

    //3ª Parte: Usa o comando while para armazenar os registros do Banco de Dados em um Array Associativo
    while($usuario = mysqli_fetch_assoc($res)){
        $idUsuario             = $usuario['idUsuario'];
        $fotoUsuario           = $usuario['fotoUsuario'];
        $nomeUsuario           = $usuario['nomeUsuario'];
        $dataNascimentoUsuario = $usuario['dataNascimentoUsuario'];
        $diaNascimentoUsuario  = substr($dataNascimentoUsuario, 8, 2);
        $mesNascimentoUsuario  = substr($dataNascimentoUsuario, 5, 2);
        $anoNascimentoUsuario  = substr($dataNascimentoUsuario, 0, 4);
        $cidadeUsuario         = $usuario['cidadeUsuario'];
        $emailUsuario          = $usuario['emailUsuario'];
        $nivelUsuario          = $usuario['nivelUsuario'];

        //4ª Parte: Exibe os registros armazenados nas variáveis
        echo "
            <tr>
                <td>$idUsuario</td>
                <td><img src='$fotoUsuario' style='width:50px;' class='rounded' title='Foto de $nomeUsuario'></td>
                <td>$nomeUsuario</td>
                <td>$diaNascimentoUsuario/$mesNascimentoUsuario/$anoNascimentoUsuario</td>
                <td>$cidadeUsuario</td>
                <td>$emailUsuario</td>
                <td>$nivelUsuario</td>
                <td><a href='#banirUsuario.php' title='Banir $nomeUsuario'><i class='bi bi-x-circle' style='color:red'></i></a></td>
            </tr>
        ";
    }
    // 5ª Parte: Encerra a tabela e a conexão com o Banco de Dados
    echo "</tbody>";
    echo "</table>";
    mysqli_close($conn); //Encerra a conexão com o Banco de Dados
?>

<?php include "footer.php" ?>