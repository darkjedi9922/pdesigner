<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */

$this->context->layout = 'simple'; // эта страница имеет свой собственный шаблон
?>

<div class="desk">
    <div class="box box--page-centered">
        <div class="breadcrumbs">
            <a href="/web" class="breadcrumbs__link">Главная</a>
            <i class="breadcrumbs__divisor"></i>
            <span class="breadcrumbs__item">Вход</span>
        </div>
        <br>
        <form class="login-form" method="post">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <div class="login-form__field">
                <span class="login-form__label">Логин:</span>
                <div class="login-form__input-container">
                    <div class="login-form__icon">
                        <i class="icon user"></i>
                    </div><input class="login-form__input" type="text" name="LoginForm[username]" value="<?= Html::encode($model->username) ?>">
                </div>
            </div>
            <div class="login-form__field">
                <span class="login-form__label">Пароль:</span>
                <div class="login-form__input-container">
                    <div class="login-form__icon">
                        <i class="icon lock"></i>
                    </div><input class="login-form__input" type="password" name="LoginForm[password]">
                </div>
            </div>
            <div class="login-form__field">
                <label class="form-checkbox">
                    <input type="hidden" name="LoginForm[rememberMe]" value="0">
                    <input class="form-checkbox__input" type="checkbox" name="LoginForm[rememberMe]" value="1" <?php if ($model->rememberMe) echo 'checked' ?>>
                    <div class="form-checkbox__box">
                        <i class="icon check"></i>
                    </div>
                    <span class="form-checkbox__label">Запомнить меня</span>
                </label>
            </div>
            <button class="login-form__button">Войти</button>
        </form>
    </div>
</div>