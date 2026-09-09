<?php include "header.php" ?>

    <?php
        //Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Cria variáveis para armazenar as informações recebidas do array $_POST
            $fotoAnuncio = $tituloAnuncio = $descricaoAnuncio = $categoriaAnuncio = $valorAnuncio = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Variáveis para armazenar a data e a hora do Anúncio
            $dataAnuncio = date("Y-m-d");
            $horaAnuncio = date("H:i:s");

            //Validação do campo tituloAnuncio
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["tituloAnuncio"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>TÍTULO DO ANÚNCIO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["tituloAnuncio"] não estiver vazio, é filtrado e armazenado na variável PHP
                $tituloAnuncio = filtrar_entrada($_POST["tituloAnuncio"]);
            }

            //Validação do campo descricaoAnuncio
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["descricaoAnuncio"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DESCRIÇÃO DO ANÚNCIO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["descricaoAnuncio"] não estiver vazio, é filtrado e armazenado na variável PHP
                $descricaoAnuncio = filtrar_entrada($_POST["descricaoAnuncio"]);
            }

            //Validação do campo categoriaAnuncio
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["categoriaAnuncio"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CATEGORIA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["categoriaAnuncio"] não estiver vazio, é filtrado e armazenado na variável PHP
                $categoriaAnuncio = filtrar_entrada($_POST["categoriaAnuncio"]);
            }

            //Validação do campo valorAnuncio
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["valorAnuncio"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>VALOR DO ANÚNCIO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["valorAnuncio"] não estiver vazio, é filtrado e armazenado na variável PHP
                $valorAnuncio = filtrar_entrada($_POST["valorAnuncio"]);
            }

            //Início da validação do campo fotoAnuncio
            $diretorio    = "assets/img/"; //Define para qual diretório as imagens serão movidas
            $fotoAnuncio  = $diretorio . basename($_FILES['fotoAnuncio']['name']); //Montar o nome a ser salvo no BD (asset/img/paulinho.jpg)
            $tipoDaImagem = strtolower(pathinfo($fotoAnuncio, PATHINFO_EXTENSION)); //Pega a extensão da imagem convertida em letras minúsculas
            $erroUpload   = false; //Variável para controle de erros no upload da foto

            //Verifica se o tamanho do arquivo é diferente de ZERO
            if($_FILES['fotoAnuncio']['size'] != 0){
                //Inicia a validação do arquivo fotoAnuncio

                //Verifica se o tamanho da foto é maior do que 5 MegaBytes (MB) (5000000 bytes)
                if($_FILES['fotoAnuncio']['size'] > 5000000){
                    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve ser menor do que 5MB!</div>";
                    $erroUpload = true;
                }

                //Verifica se a foto está nos formatos jpg, jpeg, png ou webp
                if($tipoDaImagem != "jpg" && $tipoDaImagem != "jpeg" && $tipoDaImagem != "png" && $tipoDaImagem != "webp"){
                    echo "<div class='alert alert-warning text-center'>A <strong>FOTO</strong> deve estar nos formatos JPG, JPEG, PNG ou WEBP!</div>";
                    $erroUpload = true;
                }

                //Verifica se a foto foi movida para o diretório (assets/img/), utilizando a função move_uploaded_file()
                if(!move_uploaded_file($_FILES["fotoAnuncio"]["tmp_name"], $fotoAnuncio)){
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

                //Cria uma variável para armazenar a QUERY que realiza a inserção de dados na tabela Anuncios
                $inserirAnuncio = "INSERT INTO Anuncios (Usuarios_idUsuario, fotoAnuncio, tituloAnuncio, descricaoAnuncio, categoriaAnuncio, valorAnuncio, dataAnuncio, horaAnuncio, statusAnuncio)
                                VALUES ($idUsuario, '$fotoAnuncio', '$tituloAnuncio', '$descricaoAnuncio', '$categoriaAnuncio', '$valorAnuncio', '$dataAnuncio', 'horaAnuncio', 'Disponível')";

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                //Usa a função mysqli_query() para executar a QUERY no Banco de Dados
                //Se conseguir, exibe alerta de sucesso e tabela com os dados informados
                //if(mysqli_query($conn, $inserirAnuncio)){

                    echo "<div class='alert alert-success text-center'>O cadastro do <strong>ANÚNCIO</strong> foi efetuado com sucesso!</div>";
                    echo "
                        <div class='container mb-3 mt-3'>
                            <div class='container mb-3 mt-3 text-center'>
                                <img src='$fotoAnuncio' title='Foto de $tituloAnuncio' style='width:150px' class='img-thumbnail'>
                            </div>
                            <table class='table'>
                                <tr>
                                    <th>TÍTULO DO ANÚNCIO</th>
                                    <td>$tituloAnuncio</td>
                                </tr>
                                <tr>
                                    <th>DESCRIÇÃO DO ANÚNCIO</th>
                                    <td>$descricaoAnuncio</td>
                                </tr>
                                <tr>
                                    <th>CATEGORIA</th>
                                    <td>$categoriaAnuncio</td>
                                </tr>
                                <tr>
                                    <th>VALOR DO ANÚNCIO</th>
                                    <td>$valorAnuncio</td>
                                </tr>
                                <tr>
                                    <th>DATA DO ANÚNCIO</th>
                                    <td>$dataAnuncio</td>
                                </tr>
                                <tr>
                                    <th>HORA DO ANÚNCIO</th>
                                    <td>$horaAnuncio</td>
                                </tr>
                                <tr>
                                    <th>USUÁRIO ANUNCIANTE</th>
                                    <td>$idUsuario</td>
                                </tr>
                            </table>
                        </div>
                    ";
            /*    }
                else{
                    echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>USUÁRIO</strong> no banco de dados!</div>";
                }*/
            }
        }
        else{
            //Usa a função header() para redirecionar o usuário para o formAnuncio.php
            header("location:formAnuncio.php");
        }

        //Função para filtrar entrada de dados e evitar SQL Injection
        function filtrar_entrada($dado){
            $dado = trim($dado); //Remove espaços desnecessários
            $dado = stripslashes($dado); //Remove barras invertidas
            $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

            //Após o dado passar pelos filtros, é retornado
            return($dado);
        }
    ?>

<?php include "footer.php" ?>