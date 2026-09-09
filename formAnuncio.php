<?php include "header.php" ?>

    <div class="d-flex justify-content-center mb-3">
        <h2>Cadastro de Anúncio</h2>
    </div>

    <div class="d-flex justify-content-center mb-3">
        <form action="actionAnuncio.php" method="POST" class="was-validated" enctype="multipart/form-data">

            <div class="form-floating mt-3 mb-3">
                <input type="file" name="fotoAnuncio" id="fotoAnuncio" placeholder="Foto" class="form-control">
                <label for="fotoAnuncio">Foto</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="tituloAnuncio" id="tituloAnuncio" placeholder="Insira o título do Anúncio" class="form-control">
                <label for="tituloAnuncio">Título do Anúncio</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <textarea name="descricaoAnuncio" id="descricaoAnuncio" placeholder="Informe uma breve descrição detalhando o seu anúncio" class="form-control"></textarea>
                <label for="descricaoAnuncio">Descrição do Anúncio</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <select name="categoriaAnuncio" id="categoriaAnuncio" placeholder="Selecione uma Categoria" class="form-control">
                    <option value="Alimentos">Alimentos</option>
                    <option value="Eletrônicos">Eletrônicos</option>
                    <option value="Imóveis">Imóveis</option>
                    <option value="Veículos">Veículos</option>
                    <option value="Vestuário">Vestuário</option>
                    <option value="Outra">Outra</option>
                </select>
                <label for="categoriaAnuncio">Categoria</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-floating mt-3 mb-3">
                <input type="text" name="valorAnuncio" id="valorAnuncio" placeholder="Informe o valor do anúncio em R$" class="form-control">
                <label for="valorAnuncio">Valor do Anúncio</label>
                <div class="valid-feedback"></div>
                <div class="invalid-feedback"></div>
            </div>

            <button type="submit" class="btn btn-outline-dark">Criar Anúncio</button>

        </form>

    </div>

<?php include "footer.php" ?>