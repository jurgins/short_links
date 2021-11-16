<header>
    <div class="container middle">
        <div class="logo">
            <img src="/short_links/public/img/cat2.jpeg" alt="Logo">
            <span>Уберем все лишнее из ссылки!</span>
        </div>
        <div class="auth-checkout">
            <a href="/short_links/">Главная</a>
            <a href="/short_links/contact/about">Про нас</a>
            <a href="/short_links/contact">Контакты</a>
            <?php if(!isset($_COOKIE['login'])): ?>
<!--            --><?php //var_dump($_COOKIE) ?>
                <a href="/short_links/user/auth"><button class="btn auth">Войти</button></a>
            <?php else: ?>
                <a href="/short_links/user"><button class="btn dashboard">Кабинет пользователя</button></a>
            <?php endif; ?>
        </div>
    </div>
</header>