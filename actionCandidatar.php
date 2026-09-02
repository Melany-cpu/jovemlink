<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "conexaoBD.php";

echo "<h3>Diagnóstico da Candidatura</h3>";

// 1. Verifica sessão do usuário
$idUsuarioSessao = $_SESSION['idUsuario'] ?? $_SESSION['idCandidato'] ?? null;
echo "ID na sessão: " . ($idUsuarioSessao ? "<b>$idUsuarioSessao</b>" : "<span style='color:red;'>NÃO ENCONTRADO</span>") . "<br>";

// 2. Verifica se o ID da vaga foi enviado
$idVaga = $_POST['idVaga'] ?? $_POST['id_vaga'] ?? null;
echo "ID da Vaga recebido: " . ($idVaga ? "<b>$idVaga</b>" : "<span style='color:red;'>NÃO RECEBIDO (Verifique o name do input no HTML)</span>") . "<br>";

if (!$idUsuarioSessao || !$idVaga) {
    die("<br><b style='color:red;'>Interrompido: Falta o ID da sessão ou o ID da vaga.</b>");
}

// 3. Garante existência do candidato na tabela 'candidato'
$idCandidatoFinal = null;
$sqlCheck = "SELECT idCandidato FROM candidato WHERE idCandidato = '$idUsuarioSessao' LIMIT 1";
$resCheck = mysqli_query($conn, $sqlCheck);

if ($resCheck && mysqli_num_rows($resCheck) > 0) {
    $row = mysqli_fetch_assoc($resCheck);
    $idCandidatoFinal = $row['idCandidato'];
    echo "Candidato encontrado no banco! ID: <b>$idCandidatoFinal</b><br>";
} else {
    echo "Candidato não existia na tabela 'candidato'. Tentando criar agora...<br>";
    
    $sqlUser = "SELECT * FROM usuarios WHERE idUsuario = '$idUsuarioSessao' LIMIT 1";
    $resUser = mysqli_query($conn, $sqlUser);

    if ($resUser && mysqli_num_rows($resUser) > 0) {
        $dadosUser = mysqli_fetch_assoc($resUser);
        $nome  = mysqli_real_escape_string($conn, $dadosUser['nomeUsuario']);
        $email = mysqli_real_escape_string($conn, $dadosUser['emailUsuario']);
        $senha = mysqli_real_escape_string($conn, $dadosUser['senhaUsuario']);

        $sqlInserts = "INSERT INTO candidato (idCandidato, nomeUsuario, emailCandidato, senhaUsuario) 
                       VALUES ('$idUsuarioSessao', '$nome', '$email', '$senha')";
        
        if (mysqli_query($conn, $sqlInserts)) {
            $idCandidatoFinal = $idUsuarioSessao;
            echo "Candidato criado com sucesso!<br>";
        } else {
            echo "<span style='color:red;'>Erro ao inserir na tabela candidato: " . mysqli_error($conn) . "</span><br>";
        }
    }
}

// 4. Executa a gravação na tabela 'candidatura'
if ($idCandidatoFinal) {
    $dataAtual = date('Y-m-d H:i:s');
    $status = 'Pendente';

    $sqlCandidatura = "INSERT INTO candidatura (idCandidato, idVaga, dataCandidatura, statusCandidatura) 
                       VALUES ('$idCandidatoFinal', '$idVaga', '$dataAtual', '$status')";

    if (mysqli_query($conn, $sqlCandidatura)) {
        echo "<br><h2 style='color:green;'>SUCESSO! Candidatura gravada no banco de dados.</h2>";
        echo "<a href='listarVagas.php'>Voltar para vagas</a>";
    } else {
        echo "<br><h2 style='color:red;'>ERRO MYSQL AO GRAVAR CANDIDATURA:</h2>";
        echo "<b>Mensagem do Banco:</b> " . mysqli_error($conn);
    }
} else {
    echo "<br><b style='color:red;'>Falha ao identificar ou criar o registro do candidato.</b>";
}
?>