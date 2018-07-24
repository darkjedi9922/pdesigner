<?php

/** @var \yii\web\View $this */

$this->context->layout = 'simple'; // эта страница имеет свой собственный шаблон
?>

<div class="desk">
    <div class="box box--page-centered">
        <form class="login-form" action="#" method="post">
            <div class="login-form__field">
                <span class="login-form__label">Логин:</span>
                <div class="login-form__input-container">
                    <div class="login-form__icon">
                        <i class="icon user"></i>
                    </div><input class="login-form__input" type="text" name="login">
                </div>
            </div>
            <div class="login-form__field">
                <span class="login-form__label">Пароль:</span>
                <div class="login-form__input-container">
                    <div class="login-form__icon">
                        <i class="icon lock"></i>
                    </div><input class="login-form__input" type="password" name="password">
                </div>
            </div>
            <div class="login-form__field">
                <label class="form-checkbox">
                    <input class="form-checkbox__input" type="checkbox" name="remember">
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