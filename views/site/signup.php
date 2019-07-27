<?php

use yii\helpers\Url;
use app\models\SignupForm;

/** @var \yii\web\View $this */
/** @var bool|null $signedUp */
/** @var \app\models\SignupForm $signupForm */

$this->context->layout = 'simple'; // эта страница имеет свой собственный шаблон
?>

<div class="desk">
    <div class="box box--page-centered">
        <div class="breadcrumb">
            <a href="<?= Url::to(['/']) ?>" class="breadcrumb__section breadcrumb__section--link">Главная</a>
            <i class="breadcrumb__divisor"></i>
            <span class="breadcrumb__section">Регистрация</span>
        </div>
        <div class="form">
            <?php if ($signedUp) : ?>
                <span class="form__result form__result--ok">Вы успешно зарегестрированы</span>
            <?php else : ?>
                <?php if (in_array(SignupForm::USERNAME_ALREADY_EXISTS, $signupForm->getErrors('username'))) : ?>
                    <span class="form__result form__result--error">Такой логин уже занят</span>
                <?php endif ?>
                <form method="post">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
                    <div class="form__field">
                        <span class="form__label">Логин:</span>
                        <div class="form__input-container">
                            <div class="form__icon">
                                <i class="icon user"></i>
                            </div><input 
                                class="form__input form__input--icon" 
                                type="text" 
                                name="SignupForm[username]"
                                value="<?= $signupForm->username ?>"
                            >
                        </div>
                    </div>
                    <div class="form__field">
                        <span class="form__label">Пароль:</span>
                        <div class="form__input-container">
                            <div class="form__icon">
                                <i class="icon lock"></i>
                            </div><input 
                                class="form__input form__input--icon" 
                                type="password" 
                                name="SignupForm[password]"
                            >
                        </div>
                    </div>
                    <button class="form__button">Зарегестрироваться</button>
                </form>
            <?php endif ?>
        </div>
    </div>
</div>