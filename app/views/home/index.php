<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <meta name="description" content="Главная страница сайта" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/short_links/public/css/main.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="/short_links/public/css/form.css" type="text/css" charset="utf-8">
</head>
<body>
    <?php require_once 'public/blocks/header.php'; ?>

    <div class="container main">
        <h1>Сокра.тим</h1>
        <?php if (!isset($_COOKIE['login'])): ?>
            <p>Вам нужно сократить ссылку? Прежде чем это сделать зарегистрируйтесь на сайте</p>
            <form action="/short_links/" method="post" class="form-controll">
                <input type="email" name="email" placeholder="Введите email" value="<?=$_POST['email'] ?? ''?>"><br>
                <input type="text" name="name" placeholder="Введите логин" value="<?=$_POST['name'] ?? ''?>"><br>
                <input type="password" name="pass" placeholder="Введите пароль" value="<?=$_POST['pass'] ?? ''?>"><br>
                <div class="error"><?=$data['message'] ?? ''?></div>
                <button class="btn" id="send">Зарегистрироваться</button>
                <p>Есть аккаунт? Тогда Вы можете <a href="/short_links/user/auth">авторизоваться</a></p>
            </form>
        <?php else: ?>
            <p>Вам нужно сократить ссылку? Сейчас мы это сделаем!</p>
            <form action="/short_links/" method="post" class="form-controll">
<!--                <input type="hidden" name="linkForm">-->
                <input type="text" name="long_link" placeholder="Длинная ссылка" value="<?=$_POST['long_link'] ?? ''?>"><br>
                <input type="text" name="short_link" placeholder="Короткое название" value="<?=$_POST['short_link'] ?? ''?>"><br>
                <div class="error"><?=$data['message'] ?? ''?></div>
                <button class="btn" id="send">Уменьшить</button>
            </form>

            <?php if(!empty($data['links'])): ?>
                <?php for($i = 0; $i < count($data['links']); $i++): ?>
                    <div class="link">
                        <a href="<?=$data['links'][$i]['long_link']?>"><?=$data['links'][$i]['long_link']?></a>
                        <a href="<?=$data['links'][$i]['long_link']?>"><p><?=$data['links'][$i]['short_link']?></p></a>
                        <form action="/short_links/" method="post">
                            <input type="hidden" name="remove_link_id" value="<?=$data['links'][$i]['id']?>">
                            <button class="btn">Удалить <span><img src="/shop/public/img/delete.png" alt="delete product"></span></button>
                        </form>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <?php require_once 'public/blocks/footer.php'; ?>
</body>
</html>