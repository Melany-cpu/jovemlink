<?php include "header.php" ?>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Cadastro da Empresa:</h2>

              <form action="actionEmpresa.php" method="POST" enctype="multipart/form-data">

              <h5 class="fw-bold mb-2 text-uppercase">Dados da Empresa:</h5>
              
              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="file" name="fotoEmpresa" id="fotoEmpresa" class="form-control">
                <label for="fotoEmpresa">Logo da Empresa</label>
              </div>

              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="text" name="nomeEmpresa" id="nomeEmpresa" placeholder="Nome" class="form-control form-control-lg" required />
                <label for="nomeEmpresa">Nome da Empresa</label>
              </div>
              
              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="text" name="razaoSocialEmpresa" id="razaoSocialEmpresa" placeholder="Razão Social" class="form-control form-control-lg" />
                <label for="razaoSocialEmpresa">Razão Social</label>
              </div>

              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="date" name="dataFundacaoEmpresa" id="dataFundacaoEmpresa" class="form-control">
                <label for="dataFundacaoEmpresa">Data de Fundação</label>
              </div>

              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="text" name="cnpjEmpresa" id="cnpjEmpresa" placeholder="00.000.000/0000-00" class="form-control form-control-lg" maxlength="18" />
                <label for="cnpjEmpresa">CNPJ</label>
              </div>

              <h5 class="fw-bold mb-2 mt-4 text-uppercase">Localização:</h5>
              <div class="form-floating mt-3 mb-3 text-dark">
                <select name="estadoEmpresa" id="estadoEmpresa" class="form-select">
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
                  <option value="PR" selected>Paraná</option>
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
                <label for="estadoEmpresa">Estado</label>
              </div>

              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="text" name="cidadeEmpresa" id="cidadeEmpresa" placeholder="Cidade" class="form-control form-control-lg" />
                <label for="cidadeEmpresa">Cidade</label>
              </div>

              <h5 class="fw-bold mb-2 mt-4 text-uppercase">Conta e Acesso:</h5>

              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="email" name="emailEmpresa" id="emailEmpresa" placeholder="empresa@exemplo.com" class="form-control form-control-lg" required />
                <label for="emailEmpresa">Email da Empresa:</label>
              </div>

              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="password" name="senhaEmpresa" id="senhaEmpresa" placeholder="Senha" class="form-control form-control-lg" required />
                <label for="senhaEmpresa">Senha</label>
              </div>

              <div class="form-floating mt-3 mb-3 text-dark">
                <input type="password" name="confirmarSenhaEmpresa" id="confirmarSenhaEmpresa" placeholder="Confirmar Senha" class="form-control form-control-lg" required />
                <label for="confirmarSenhaEmpresa">Confirmar Senha</label>
              </div>

              <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5 mt-3" type="submit">Cadastrar</button>
              
              </form>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>