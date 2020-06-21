<?php

/** @var $this yii\web\View */

use yii\helpers\Url;

$isLogged = !Yii::$app->user->isGuest;
?>

<div class="landing">
    <div class="header landing__header">
        <span class="header__sitename">Project Designer</span>
        <div class="header__links header-links">
            <?php if ($isLogged) : ?>
                <span class="header-links__user"><?= Yii::$app->user->identity->username ?></span>
                <form action="<?= Url::to(['/site/logout']) ?>" method="post">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                    <label>
                        <input type="submit" style="display:none">
                        <a class="header-links__button">Выход</a>
                    </label>
                </form>
            <?php else : ?>
                <a href="<?= Url::to(['/site/login']) ?>" class="header-links__link">Вход</a>
                <a href="<?= Url::to(['/site/signup']) ?>" class="header-links__button">Регистрация</a>
            <?php endif ?>
        </div>
    </div>
    <div class="landing__content">
        <div class="start">
            <a href="<?= Url::to(['/dashboard']) ?>" class="start__button"><i class="icon play"></i></a>
        </div>
        <div class="features">
            <div class="feature features__item">
                <div class="feature__icon feature__icon--projects"><i class="icon copy"></i></div>
                <h3 class="feature__title">Проекты</h3>
                <p class="feature__desc">
                    Бесконечное количество проектов для каждого пользователя.
                    При описании проекта можно использовать возможности Markdown.
                </p>
            </div>
            <div class="feature features__item">
                <div class="feature__icon feature__icon--tasks"><i class="icon check"></i></div>
                <h3 class="feature__title">Задачи</h3>
                <p class="feature__desc">
                    Задачи могут вкладываться друг в друга. У них есть различные состояния, по которым
                    их можно разделять на две общие категории: активные и выполненные. Их также можно
                    описывать с использованием Markdown.
                </p>
            </div>
            <div class="feature features__item">
                <div class="feature__icon feature__icon--groups"><i class="icon flag"></i></div>
                <h3 class="feature__title">Группы задач</h3>
                <p class="feature__desc">
                    В проектах можно создавать группы задач для любых целей.
                    Каждой группе можно задавать название и цвет.
                </p>
            </div>
        </div>
    </div>
    <div class="footer landing__footer">
        <span class="footer__powered">Powered with Yii 2 Framework</span>
        <span class="footer__created">Created by Jed Sidious Alex Everdeen Dark</span>
        <span class="footer__time">2018 - 2020</span>
    </div>
</div>