<?php
// 1. Inicia a sessão no topo antes de qualquer saída de texto ou HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Inclui a conexão e a estrutura
include "conexaoBD.php"; 
include "header.php"; 
?>
<br><br><br>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Processamento da Foto
    $diretorio = "assets/img/"; 
    if (!file_exists($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    $fotoName   = $_FILES['fotoEmpresa']['name'] ?? '';
    $erroUpload = false; 

    if (isset($_FILES['fotoEmpresa']) && $_FILES['fotoEmpresa']['size'] > 0) {
        $fotoEmpresa = $diretorio . time() . "_" . basename($fotoName);
        if (!move_uploaded_file($_FILES["fotoEmpresa"]["tmp_name"], $fotoEmpresa)) {
            echo "<div class='alert alert-danger text-center'>Erro ao enviar a imagem de perfil.</div>";
            $erroUpload = true;
        }
    } else {
        $fotoEmpresa = $diretorio . "default_empresa.png";
    }

    // 2. Captura dos demais campos
    $nomeEmpresa        = filtrar_entrada($_POST["nomeEmpresa"] ?? "");
    $razaoSocialEmpresa = filtrar_entrada($_POST["razaoSocialEmpresa"] ?? "");
    $dataFundacaoRaw    = filtrar_entrada($_POST["dataFundacaoEmpresa"] ?? "");
    $cnpjEmpresa        = filtrar_entrada($_POST["cnpjEmpresa"] ?? "");
    $estadoEmpresa      = filtrar_entrada($_POST["estadoEmpresa"] ?? "");
    $cidadeEmpresa      = filtrar_entrada($_POST["cidadeEmpresa"] ?? "");
    $emailEmpresa       = filtrar_entrada($_POST["emailEmpresa"] ?? "");
    $senhaInput         = filtrar_entrada($_POST["senhaEmpresa"] ?? "");
    $confirmarSenhaInput= filtrar_entrada($_POST["confirmarSenhaEmpresa"] ?? "");

    // Ajuste do formato da data de fundação
    $dataFundacaoEmpresa = !empty($dataFundacaoRaw) ? date('Y-m-d', strtotime($dataFundacaoRaw)) : date('Y-m-d');

    $erroPreenchimento = false;

    // Validações
    if (empty($nomeEmpresa) || empty($emailEmpresa) || empty($senhaInput)) {
        echo "<div class='alert alert-warning text-center'>Preencha todos os campos obrigatórios!</div>";
        $erroPreenchimento = true;
    }

    if (!empty($senhaInput) && $senhaInput !== $confirmarSenhaInput) {
        echo "<div class='alert alert-warning text-center'>As senhas não coincidem!</div>";
        $erroPreenchimento = true;
    }

    // 3. Gravação no Banco de Dados
    if (!$erroPreenchimento && !$erroUpload) {
        
        $senhaEmpresa = md5($senhaInput);
        $dataCadastro = date('Y-m-d H:i:s');

        // Escapa os textos para evitar erros de sintaxe no MySQL
        $nomeEmpresa        = mysqli_real_escape_string($conn, $nomeEmpresa);
        $razaoSocialEmpresa = mysqli_real_escape_string($conn, $razaoSocialEmpresa);
        $cnpjEmpresa        = mysqli_real_escape_string($conn, $cnpjEmpresa);
        $estadoEmpresa      = mysqli_real_escape_string($conn, $estadoEmpresa);
        $cidadeEmpresa      = mysqli_real_escape_string($conn, $cidadeEmpresa);
        $emailEmpresa       = mysqli_real_escape_string($conn, $emailEmpresa);

        $sql = "INSERT INTO Empresa (
                    fotoEmpresa, 
                    nomeEmpresa, 
                    razaoSocialEmpresa, 
                    dataFundacaoEmpresa, 
                    cnpjEmpresa, 
                    estadoEmpresa, 
                    cidadeEmpresa, 
                    emailEmpresa, 
                    senhaEmpresa, 
                    dataCadastro
                ) VALUES (
                    '$fotoEmpresa', 
                    '$nomeEmpresa', 
                    '$razaoSocialEmpresa', 
                    '$dataFundacaoEmpresa', 
                    '$cnpjEmpresa', 
                    '$estadoEmpresa', 
                    '$cidadeEmpresa', 
                    '$emailEmpresa', 
                    '$senhaEmpresa', 
                    '$dataCadastro'
                )";

        if (mysqli_query($conn, $sql)) {
            // Define as sessões para a empresa recém-cadastrada estar logada
            $_SESSION['idEmpresa']    = mysqli_insert_id($conn);
            $_SESSION['nomeEmpresa']  = $nomeEmpresa;
            $_SESSION['emailEmpresa'] = $emailEmpresa;
            $_SESSION['logado']       = true;

            // Redireciona para o formulário de cadastro de vaga
            echo "<script>alert('Empresa cadastrada com sucesso! Cadastre sua primeira vaga.'); window.location.href = 'formCadastrarVaga.php';</script>";
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Erro no banco de dados: <strong>" . mysqli_error($conn) . "</strong></div>";
        }
    }

} else {
    header("Location: formEmpresa.php");
    exit();
}

function filtrar_entrada($dado) {
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}
?>

<?php include "footer.php"; ?>