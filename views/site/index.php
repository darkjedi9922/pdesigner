<?php

/** @var $this yii\web\View */

use yii\helpers\Url;

$isLogged = !Yii::$app->user->isGuest;
?>

<div class="landing">
    <div class="slide">
        <div class="header">
            <span class="header__sitename">Project Designer</span>
            <div class="header__links header-links">
                <?php if ($isLogged): ?>
                    <form action="<?= Url::to(['/site/logout']) ?>" method="post">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        <label>
                            <input type="submit" style="display:none">
                            <a class="header-links__button">Выход</a>
                        </label>
                    </form>
                <?php else: ?>
                    <a href="<?= Url::to(['/site/login']) ?>" class="header-links__link">Вход</a>
                    <a href="<?= Url::to(['/site/signup']) ?>" class="header-links__button">Регистрация</a>
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
                    <a href="<?= Url::to(['/dashboard']) ?>" class="slide__button">Начать</a>
                </div>
            </div>
            <div class="slide__image">
                <img src="<?= Url::to(['/images/slide_1.png']) ?>">
            </div>
        </div>
        <div class="footer">
            <span class="footer__powered">Powered by Yii 2 Framework</span>
            <span class="footer__created">Created by Jed Sidious Alex Everdeen Dark</span>
            <span class="footer__time">2018</span>
        </div>
    </div>
</div>