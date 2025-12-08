<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Recupera tu acceso a DevWebCamp</p>

    <form class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Email</label>
            <input type="email" name="email" id="email" placeholder="Tu email" class="formulario__input">
        </div>

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Password:</label>
            <input type="password" name="password" id="password" placeholder="Tu password" class="formulario__input">
        </div>

        <input type="submit" class="formulario__submit" value="Enviar Instrucciones">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">Iniciar Sesión</a>
        <a href="/registro" class="acciones__enlace">Crear Cuenta</a>
    </div>
</main>