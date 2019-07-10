<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \yii\web\View $this */

$this->context->layout = 'simple'; // эта страница имеет свой собственный шаблон
?>

<div class="desk">
    <div class="box box--page-centered">
        <div class="breadcrumb">
            <a href="<?= Url::to(['/']) ?>" class="breadcrumb__section breadcrumb__section--link">Главная</a>
            <i class="breadcrumb__divisor"></i>
            <span class="breadcrumb__section">Вход</span>
        </div>
        <form class="form" method="post">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
            <div class="form__field">
                <span class="form__label">Логин:</span>
                <div class="form__input-container">
                    <div class="form__icon">
                        <i class="icon user"></i>
                    </div><input class="form__input form__input--icon" type="text" name="LoginForm[username]" value="<?= Html::encode($model->username) ?>">
                </div>
            </div>
            <div class="form__field">
                <span class="form__label">Пароль:</span>
                <div class="form__input-container">
                    <div class="form__icon">
                        <i class="icon lock"></i>
                    </div><input class="form__input form__input--icon" type="password" name="LoginForm[password]">
                </div>
            </div>
            <div class="form__field">
                <label class="form-checkbox">
                    <input type="hidden" name="LoginForm[rememberMe]" value="0">
                    <input class="form-checkbox__input" type="checkbox" name="LoginForm[rememberMe]" value="1" <?php if ($model->rememberMe) echo 'checked' ?>>
                    <div class="form-checkbox__box">
                        <i class="icon check"></i>
                    </div>
                    <span class="form-checkbox__label">Запомнить меня</span>
                </label>
            </div>
            <button class="form__button">Войти</button>
        </form>
    </div>
</div>