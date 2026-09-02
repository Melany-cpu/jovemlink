<?php include "header.php" ?>
<br>
<br>
<br>

    <?php
        //Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Cria variáveis para armazenar as informações recebidas do array $_POST
            $fotoUsuario = $dataNascimentoUsuario = $nomeUsuario = $cpfUsuario = $emailUsuario = $estadoUsuario = $cidadeUsuario = $senhaUsuario = $confirmarSenhaUsuario = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Validação do campo dataNascimentoUsuario
            if(empty($_POST["dataNascimentoUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DE NASCIMENTO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $dataNascimentoUsuario = filtrar_entrada($_POST["dataNascimentoUsuario"]);

                if(strlen($dataNascimentoUsuario) == 10){
                    $diaNascimentoUsuario = substr($dataNascimentoUsuario, 8, 2);
                    $mesNascimentoUsuario = substr($dataNascimentoUsuario, 5, 2);
                    $anoNascimentoUsuario = substr($dataNascimentoUsuario, 0, 4);
                }
                else{
                    echo "<div class='alert alert-warning text-center'><strong>DATA</strong> inválida!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo nomeUsuario
            if(empty($_POST["nomeUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $nomeUsuario = filtrar_entrada($_POST["nomeUsuario"]);

                if(!preg_match('/^[\p{L} ]+$/u', $nomeUsuario)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo cpfUsuario
            if(empty($_POST["cpfUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CPF</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $cpfUsuario = filtrar_entrada($_POST["cpfUsuario"]);
            }

            //Validação do campo emailUsuario
            if(empty($_POST["emailUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $emailUsuario = filtrar_entrada($_POST["emailUsuario"]);
            }

            //Validação do campo estadoUsuario
            if(empty($_POST["estadoUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>ESTADO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $estadoUsuario = filtrar_entrada($_POST["estadoUsuario"]);
            }

            //Validação do campo cidadeUsuario
            if(empty($_POST["cidadeUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CIDADE</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $cidadeUsuario = filtrar_entrada($_POST["cidadeUsuario"]);
            }

            //Validação do campo senhaUsuario
            if(empty($_POST["senhaUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $senhaUsuario = md5(filtrar_entrada($_POST["senhaUsuario"]));
            }

            //Validação do campo confirmarSenhaUsuario
            if(empty($_POST["confirmarSenhaUsuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                $confirmarSenhaUsuario = md5(filtrar_entrada($_POST["confirmarSenhaUsuario"]));

                if($senhaUsuario != $confirmarSenhaUsuario){
                    echo "<div class='alert alert-warning text-center'>As <strong>SENHAS</strong> informadas não são iguais!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Início da validação do campo fotoUsuario
            $diretorio    = "assets/img/";
            $fotoUsuario  = $diretorio . basename($_FILES['fotoUsuario']['name']);
            $tipoDaImagem = strtolower(pathinfo($fotoUsuario, PATHINFO_EXTENSION));
            $erroUpload   = false;

            if(isset($_FILES['fotoUsuario']) && $_FILES['fotoUsuario']['size'] != 0){

                if($_FILES['fotoUsuario']['size'] > 5000000){
                    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve ser menor do que 5MB!</div>";
                    $erroUpload = true;
                }

                if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve estar nos formatos JPG, JPEG, PNG ou WEBP!</div>";
                    $erroUpload = true;
                }

                if(!move_uploaded_file($_FILES["fotoUsuario"]["tmp_name"], $fotoUsuario)){
                    echo "<div class='alert alert-danger text-center'>Erro ao tentar mover a foto para o diretório <strong>$diretorio</strong>!</div>";
                    $erroUpload = true;
                }
            }
            else{
                echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> é obrigatória!</div>";
                $erroUpload = true;
            }

            //Verifica se não há erro de preenchimento
            if(!$erroPreenchimento && !$erroUpload){

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                //Cria a variável para armazenar a QUERY (com nome 'usuarios' em minúsculo)
                $inserirUsuario = "INSERT INTO usuarios (fotoUsuario, dataNascimentoUsuario, nomeUsuario, cpfUsuario, emailUsuario, estadoUsuario, cidadeUsuario, senhaUsuario, confirmarSenhaUsuario, nivelUsuario) VALUES ('$fotoUsuario', '$dataNascimentoUsuario', '$nomeUsuario', '$cpfUsuario', '$emailUsuario', '$estadoUsuario', '$cidadeUsuario', '$senhaUsuario', '$confirmarSenhaUsuario', 'usuario')";

                if(mysqli_query($conn, $inserirUsuario)){

                    //Inicia a sessão para logar o novo usuário automaticamente
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    $_SESSION['idUsuario']   = mysqli_insert_id($conn);
                    $_SESSION['nomeUsuario'] = $nomeUsuario;
                    $_SESSION['nivelUsuario']= 'usuario';

                    //Redireciona diretamente para a página de vagas
                    header("Location: listarVagas.php");
                    exit();

                }
                else{
                    echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>USUÁRIO</strong> no banco de dados!</div>";
                }
            }

        }
        else{
            header("location:formUsuario.php");
            exit();
        }

        //Função para filtrar entrada de dados
        function filtrar_entrada($dado){
            $dado = trim($dado);
            $dado = stripslashes($dado);
            $dado = htmlspecialchars($dado);
            return($dado);
        }
    ?>

<?php include "footer.php" ?>