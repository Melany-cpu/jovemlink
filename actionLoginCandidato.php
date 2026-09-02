<?php include "header.php"; ?>
<br><br><br>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexaoBD.php";

    $emailInput = filtrar_entrada($_POST["emailUsuario"] ?? '');
    $senhaInput = $_POST["senhaUsuario"] ?? '';

    if (empty($emailInput) || empty($senhaInput)) {
        echo "<div class='alert alert-warning text-center'>Preencha todos os campos!</div>";
        echo "<div class='text-center mt-3'><a href='formLogin.php' class='btn btn-primary'>Tentar novamente</a></div>";
        include "footer.php";
        exit();
    }

    // Busca o candidato na tabela usando as colunas reais
    $sql = "SELECT * FROM candidato WHERE emailUsuario = '$emailInput' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $usuario = mysqli_fetch_assoc($result);
        
        $senhaMD5 = md5(filtrar_entrada($senhaInput));
        $senhaBanco = $usuario['senhaUsuario'];

        // Aceita a senha em MD5, texto puro ou hash padrão
        if ($senhaMD5 === $senhaBanco || $senhaInput === $senhaBanco || password_verify($senhaInput, $senhaBanco)) {
            
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // 1. Limpa totalmente os dados residuais da conta anterior
            session_unset();

            // 2. Regenera a sessão criando um ID novo e seguro no servidor
            session_regenerate_id(true);

            // 3. Salva com precisão os dados do NOVO usuário logado
            $idCandidato = $usuario['idCandidato'];

            $_SESSION['logado']        = true;
            $_SESSION['idCandidato']   = $idCandidato;
            $_SESSION['idUsuario']     = $idCandidato; 
            $_SESSION['nomeCandidato'] = $usuario['nomeUsuario'] ?? 'Candidato';
            $_SESSION['nomeUsuario']   = $usuario['nomeUsuario'] ?? 'Candidato';
            $_SESSION['emailUsuario']  = $usuario['emailUsuario'] ?? '';
            $_SESSION['fotoUsuario']   = $usuario['fotoUsuario'] ?? '';

            header('Location: listarVagas.php');
            exit();
        }
    }

    // Mensagem de erro caso e-mail/senha não confirmem no banco
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