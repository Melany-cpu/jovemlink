<?php include "header.php"; ?>
<br><br><br>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexaoBD.php";

    // 1. Pega os dados digitados crus (sem aplicar md5 diretamente)
    $emailInput = filtrar_entrada($_POST["emailUsuario"] ?? '');
    $senhaInput = $_POST["senhaUsuario"] ?? '';

    if (empty($emailInput) || empty($senhaInput)) {
        echo "<div class='alert alert-warning text-center'>Preencha todos os campos!</div>";
        echo "<div class='text-center mt-3'><a href='formLogin.php' class='btn btn-primary'>Tentar novamente</a></div>";
        include "footer.php";
        exit();
    }

    // 2. Busca o usuário APENAS pelo e-mail
    $sql = "SELECT * FROM usuarios WHERE emailUsuario = '$emailInput'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
        $senhaBanco = $usuario['senhaUsuario'];

        // 3. Valida a senha (suporta password_hash moderno, MD5 antigo ou texto puro)
        if (password_verify($senhaInput, $senhaBanco) || md5($senhaInput) === $senhaBanco || $senhaInput === $senhaBanco) {
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Limpa dados anteriores e previne Session Fixation
            session_unset();
            session_regenerate_id(true);

            // Ajuste do ID primário (verifica se a coluna é idUsuario ou idCandidato)
            $idUsuario = $usuario['idUsuario'] ?? $usuario['idCandidato'] ?? null;

            $_SESSION['logado']        = true;
            $_SESSION['idCandidato']   = $idUsuario;
            $_SESSION['idUsuario']     = $idUsuario; 
            $_SESSION['nomeCandidato'] = $usuario['nomeUsuario'] ?? 'Candidato';
            $_SESSION['nomeUsuario']   = $usuario['nomeUsuario'] ?? 'Candidato';
            $_SESSION['emailUsuario']  = $usuario['emailUsuario'] ?? '';
            $_SESSION['fotoUsuario']   = $usuario['fotoUsuario'] ?? '';

            header('Location: listarVagas.php');
            exit();
        }
    }

    // Mensagem exibida caso e-mail não exista ou a senha não coincida
    echo "<div class='alert alert-danger text-center'><strong>E-MAIL</strong> ou <strong>SENHA</strong> incorretos!</div>";
    echo "<div class='text-center mt-3'><a href='formLogin.php' class='btn btn-primary'>Tentar novamente</a></div>";

} else {
    header("Location: formLogin.php");
    exit();
}

function filtrar_entrada($dado){
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}
?>

<?php include "footer.php"; ?>