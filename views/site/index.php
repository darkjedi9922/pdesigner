<?php

/** @var $this yii\web\View */

$isLogged = !Yii::$app->user->isGuest;
?>

<div class="landing">
    <div class="slide">
        <div class="header">
            <span class="header__sitename">Project Designer</span>
            <div class="header__links header-links">
                <?php if ($isLogged): ?>
                    <form action="/web/index.php?r=site/logout" method="post">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        <label>
                            <input type="submit" style="display:none">
                            <a class="header-links__button">Выход</a>
                        </label>
                    </form>
                <?php else: ?>
                    <a href="/web/index.php?r=site/login" class="header-links__link">Вход</a>
                    <a href="#" class="header-links__button">Регистрация</a>
                <?php endif ?>
            </div>
        </div>
        <div class="slide__container">
            <div class="slide__content">
                <div class="slide__desc">
                    Разрабатывайте структуру ваших проектов и воплощайте идеи с помощью Project Designer
                    <br><br>Это абсолютно бесплатно
                    <br><br>
                </div>
                <div class="slide__bar">
                    <a href="/web/index.php?r=dashboard" class="slide__button">Начать</a>
                </div>
            </div>
            <div class="slide__image">
                <img src="/web/images/slide_1.png">
            </div>
        </div>
        <div class="footer">
            <span class="footer__powered">Powered by Yii 2 Framework</span>
            <span class="footer__created">Created by Jed Sidious Alex Everdeen Dark</span>
            <span class="footer__time">2018</span>
        </div>
    </div>
</div>