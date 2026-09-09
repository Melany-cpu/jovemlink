<?php include "header.php" ?>

    <div class="d-flex justify-content-center mb-3">
        <h2>Cadastre-se</h2>
    </div>

    <div class="d-flex justify-content-center mb-3">
        <form action="actionUsuario.php" method="POST" class="was-validated" enctype="multipart/form-data">

            <div class="form-floating mt-3 mb-3">
                <input type="file" name="fotoUsuario" id="fotoUsuario" placeholder="Foto" class="form-control">
                <label for="fotoUsuario">Foto</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="nomeUsuario" id="nomeUsuario" placeholder="Nome Completo" class="form-control">
                <label for="nomeUsuario">Nome</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="date" name="dataNascimentoUsuario" id="dataNascimentoUsuario" placeholder="Data de Nascimento" class="form-control">
                <label for="dataNascimentoUsuario">Data de Nascimento</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <select name="cidadeUsuario" id="cidadeUsuario" placeholder="Cidade" class="form-control">
                    <option value="Curiúva">Curiúva</option>
                    <option value="Imbaú">Imbaú</option>
                    <option value="Ortigueira">Ortigueira</option>
                    <option value="Reserva">Reserva</option>
                    <option value="Telêmaco Borba" selected>Telêmaco Borba</option>
                    <option value="Tibagi">Tibagi</option>
                </select>
                <label for="cidadeUsuario">Cidade</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="email" name="emailUsuario" id="emailUsuario" placeholder="Email" class="form-control">
                <label for="emailUsuario">Email</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="password" name="senhaUsuario" id="senhaUsuario" placeholder="Senha" class="form-control" minlength="3" maxlength="8">
                <label for="senhaUsuario">Senha</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="password" name="confirmarSenhaUsuario" id="confirmarSenhaUsuario" placeholder="Confirme a Senha" class="form-control" minlength="3" maxlength="8">
                <label for="confirmarSenhaUsuario">Confirme a Senha</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <button type="submit" class="btn btn-outline-dark">Cadastrar</button>

        </form>

    </div>

<?php include "footer.php" ?>