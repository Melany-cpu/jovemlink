<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "header.php"; 
?>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Login de Candidato</h2>
              <p class="text-white-50 mb-4">Por favor, informe seus dados de acesso:</p>

              <!-- Exibe mensagem de erro se a senha ou e-mail estiverem incorretos -->
              <?php if (isset($_SESSION['msg_erro_login'])): ?>
                <div class="alert alert-danger mb-4" role="alert">
                  <?= $_SESSION['msg_erro_login']; ?>
                </div>
                <?php unset($_SESSION['msg_erro_login']); ?>
              <?php endif; ?>

              <form action="actionLoginCandidato.php" method="POST">
                
                <div data-mdb-input-init class="form-outline form-white mb-4 text-start">
                  <label class="form-label fw-semibold" for="emailUsuario">E-mail</label>
                  <input type="email" id="emailUsuario" name="emailUsuario" class="form-control form-control-lg" required />
                </div>

                <div data-mdb-input-init class="form-outline form-white mb-4 text-start">
                  <label class="form-label fw-semibold" for="senhaUsuario">Senha</label>
                  <input type="password" id="senhaUsuario" name="senhaUsuario" class="form-control form-control-lg" required />
                </div>

                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5 mt-3" type="submit">Entrar</button>
              
              </form>

              <div class="d-flex justify-content-center text-center mt-4 pt-1">
                <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
                <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
              </div>

            </div>

            <div>
              <p class="mb-0">Ainda não tem uma conta? <a href="formUsuario.php" class="text-white-50 fw-bold">Clique aqui!</a></p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "footer.php"; ?>