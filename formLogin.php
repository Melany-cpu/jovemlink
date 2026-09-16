<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "header.php"; 
?>

<style>
    html, body {
        margin: 0;
        padding: 0;
        min-height: 100%;
        background: linear-gradient(135deg, #2547b8, #36b7e8);
    }

    body {
        min-height: 100vh;
    }

    .login-page {
        min-height: calc(100vh - 0px);
        background: linear-gradient(135deg, #2547b8, #36b7e8);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
        box-sizing: border-box;
    }

    .login-card {
        width: 100%;
        max-width: 500px;
        background-color: #212529;
        color: white;
        border-radius: 1rem;
        border: 1px solid rgba(255, 255, 255, 0.7);
    }

    .login-card-body {
        padding: 3rem;
        text-align: center;
    }

    .login-card h2 {
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .login-card .form-label {
        font-weight: 600;
        color: white;
    }

    .login-card .form-control {
        height: 50px;
        border-radius: 8px;
    }

    .login-card .btn {
        min-width: 140px;
        border-radius: 8px;
    }

    .social-login {
        display: flex;
        justify-content: center;
        text-align: center;
        margin-top: 25px;
        padding-top: 5px;
    }

    .social-login a {
        color: white;
        text-decoration: none;
    }

    .social-login a:hover {
        color: #ccc;
    }

    .account-link {
        margin-bottom: 0;
    }

    .account-link a {
        color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
    }

    .account-link a:hover {
        color: white;
    }

    .alert {
        text-align: center;
    }

    /* Evita espaço branco causado por footer/header */
    main,
    section {
        margin: 0;
    }
</style>

<section class="login-page">

    <div class="login-card">

        <div class="login-card-body">

            <div class="mb-5">

                <h2 class="text-uppercase">
                    Login de Candidato
                </h2>

                <p class="text-white-50 mb-4">
                    Por favor, informe seus dados de acesso:
                </p>

                <?php if (isset($_SESSION['msg_erro_login'])): ?>

                    <div class="alert alert-danger mb-4" role="alert">
                        <?= htmlspecialchars($_SESSION['msg_erro_login']); ?>
                    </div>

                    <?php unset($_SESSION['msg_erro_login']); ?>

                <?php endif; ?>

                <form action="actionLoginCandidato.php" method="POST">

                    <div class="form-outline mb-4 text-start">

                        <label 
                            class="form-label" 
                            for="emailUsuario">
                            E-mail
                        </label>

                        <input 
                            type="email" 
                            id="emailUsuario" 
                            name="emailUsuario" 
                            class="form-control form-control-lg" 
                            required
                        >

                    </div>

                    <div class="form-outline mb-4 text-start">

                        <label 
                            class="form-label" 
                            for="senhaUsuario">
                            Senha
                        </label>

                        <input 
                            type="password" 
                            id="senhaUsuario" 
                            name="senhaUsuario" 
                            class="form-control form-control-lg" 
                            required
                        >

                    </div>

                    <button 
                        class="btn btn-outline-light btn-lg px-5 mt-3" 
                        type="submit">
                        Entrar
                    </button>

                </form>

                <div class="social-login">

                    <a href="#!">
                        <i class="fab fa-facebook-f fa-lg"></i>
                    </a>

                    <a href="#!">
                        <i class="fab fa-twitter fa-lg mx-4 px-2"></i>
                    </a>

                    <a href="#!">
                        <i class="fab fa-google fa-lg"></i>
                    </a>

                </div>

            </div>

            <div>

                <p class="account-link">
                    Ainda não tem uma conta?
                    <a href="formUsuario.php">
                        Clique aqui!
                    </a>
                </p>

            </div>

        </div>

    </div>

</section>
