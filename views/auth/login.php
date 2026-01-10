<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Inicia sesión en DevWebCamp</p>

    <?php 
        require_once __DIR__ . '/../templates/alertas.php';
    ?>

    <form class="formulario" method="POST" action="/login">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input type="email" name="email" id="email" placeholder="Tu email" class="formulario__input">
        </div>

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password:</label>
            <input type="password" name="password" id="password" placeholder="Tu password" class="formulario__input">
        </div>

        <input type="submit" class="formulario__submit" value="Iniciar Sesión">
        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">Crear Cuenta</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu Password?</a>
    </div>
</main>