<header class="dashboard__header">
    <div class="dashboard__header-grid">
        <a href="/"><h2 class="dashboard__logo">&#60;DevWebCamp /></h2></a>

        <nav class="dashboard__nav">
            <form method="POST" action="/logout" class="dashboard__form">
                <input type="submit" value="Cerrar Sesión" class="dashboard__submit--logout">
                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            </form>
        </nav>
    </div>
</header>