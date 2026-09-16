<?php include "header.php" ?>

<style>
    html,
    body {
        margin: 0;
        padding: 0;
        min-height: 100%;
    }

    body {
        background: linear-gradient(90deg, #1d3fae, #35a9e8);
    }

    .gradient-custom {
        min-height: 100vh;
        width: 100%;
        background: linear-gradient(90deg, #1d3fae, #35a9e8);
        padding-bottom: 50px;
    }

    .card {
        border-radius: 1rem;
    }
</style>


<section class="gradient-custom">

    <div class="container py-5">

        <div class="row d-flex justify-content-center align-items-center">

            <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                <div class="card bg-dark text-white">

                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 text-uppercase">
                                Cadastro de Usuário:
                            </h2>


                            <form 
                                action="actionCandidato.php" 
                                method="POST" 
                                enctype="multipart/form-data"
                            >


                                <!-- FOTO -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <input 
                                        type="file" 
                                        name="fotoUsuario" 
                                        id="fotoUsuario" 
                                        placeholder="Foto" 
                                        class="form-control"
                                    >

                                    <label for="fotoUsuario">
                                        Foto
                                    </label>

                                </div>


                                <!-- DATA DE NASCIMENTO -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <input 
                                        type="date" 
                                        name="dataNascimentoUsuario" 
                                        id="dataNascimentoUsuario" 
                                        placeholder="Data de Nascimento" 
                                        class="form-control"
                                    >

                                    <label for="dataNascimentoUsuario">
                                        Data de Nascimento
                                    </label>

                                </div>


                                <!-- NOME -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <input 
                                        type="text" 
                                        name="nomeUsuario" 
                                        id="nomeUsuario" 
                                        placeholder="Nome" 
                                        class="form-control form-control-lg"
                                    >

                                    <label for="nomeUsuario">
                                        Nome
                                    </label>

                                </div>


                                <!-- CPF -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <input 
                                        type="text" 
                                        name="cpfUsuario" 
                                        id="cpfUsuario" 
                                        placeholder="000.000.000-00" 
                                        class="form-control form-control-lg" 
                                        maxlength="11"
                                    >

                                    <label for="cpfUsuario">
                                        CPF
                                    </label>

                                </div>


                                <!-- EMAIL -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <input 
                                        type="email" 
                                        name="emailUsuario" 
                                        id="emailUsuario" 
                                        placeholder="nome@exemplo.com" 
                                        class="form-control form-control-lg"
                                    >

                                    <label for="emailUsuario">
                                        Email
                                    </label>

                                </div>


                                <!-- ESTADO -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <select 
                                        name="estadoUsuario" 
                                        id="estadoUsuario" 
                                        class="form-select"
                                    >

                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>

                                        <option value="PR" selected>
                                            Paraná
                                        </option>

                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>

                                    </select>

                                    <label for="estadoUsuario">
                                        Estado
                                    </label>

                                </div>


                                <!-- CIDADE -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <input 
                                        type="text" 
                                        name="cidadeUsuario" 
                                        id="cidadeUsuario" 
                                        placeholder="Cidade" 
                                        class="form-control form-control-lg"
                                    >

                                    <label for="cidadeUsuario">
                                        Cidade
                                    </label>

                                </div>


                                <!-- SENHA -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <input 
                                        type="password" 
                                        name="senhaUsuario" 
                                        id="senhaUsuario" 
                                        placeholder="Senha" 
                                        class="form-control form-control-lg"
                                    >

                                    <label for="senhaUsuario">
                                        Senha
                                    </label>

                                </div>


                                <!-- CONFIRMAR SENHA -->
                                <div class="form-floating mt-3 mb-3 text-dark">

                                    <input 
                                        type="password" 
                                        name="confirmarSenhaUsuario" 
                                        id="confirmarSenhaUsuario" 
                                        placeholder="Confirmar Senha" 
                                        class="form-control form-control-lg"
                                    >

                                    <label for="confirmarSenhaUsuario">
                                        Confirmar Senha
                                    </label>

                                </div>


                                <!-- BOTÃO -->
                                <button 
                                    data-mdb-button-init 
                                    data-mdb-ripple-init 
                                    class="btn btn-outline-light btn-lg px-5 mt-3" 
                                    type="submit"
                                >
                                    Cadastrar
                                </button>


                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
