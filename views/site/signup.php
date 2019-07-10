<?php
use yii\helpers\Url;

/** @var \yii\web\View $this */

$this->context->layout = 'simple'; // эта страница имеет свой собственный шаблон
?>

<div class="desk">
    <div class="box box--page-centered">
        <div class="breadcrumb">
            <a href="<?= Url::to(['/']) ?>" class="breadcrumb__section breadcrumb__section--link">Главная</a>
            <i class="breadcrumb__divisor"></i>
            <span class="breadcrumb__section">Регистрация</span>
        </div>
        <br>
        <?php if ($signedUp === true): ?>
            <span class="result-message">Вы успешно зарегестрированы</span>
        <?php else: ?>
            <form class="form" method="post">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
                <div class="form__field">
                    <span class="form__label">Логин:</span>
                    <div class="form__input-container">
                        <div class="form__icon">
                            <i class="icon user"></i>
                        </div><input class="form__input form__input--icon" type="text" name="SignupForm[username]">
                    </div>
                </div>
                <div class="form__field">
                    <span class="form__label">Пароль:</span>
                    <div class="form__input-container">
                        <div class="form__icon">
                            <i class="icon lock"></i>
                        </div><input class="form__input form__input--icon" type="password" name="SignupForm[password]">
                    </div>
                </div>
                <p>
                    <button class="form__button">Зарегестрироваться</button>
                </p>
            </form>
        <?php endif ?>
    </div>
</div>