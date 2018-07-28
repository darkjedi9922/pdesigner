<?php

use app\models\Issue;

/** @var \yii\web\View $this */
/** @var int|null $parent */

$parentIssue = $parent ? Issue::find()->where(['id' => $parent])->one() : null;
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="/web/index.php?r=project" class="breadcrumb__section breadcrumb__section--link">Lightness</a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Добавить задачу</span>
</div>
<div class="box">
    <?php if ($parentIssue) : ?>
        <div class="form__field">
            <span class="form__label">Задача: <?= $parentIssue['title'] ?></span>
        </div>
    <?php endif ?>
    <form method="post" class="form form--table">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <input type="hidden" name="AddTaskForm[parent]" value="<?= $parent ?>">
        <div class="form__field">
            <span class="form__label">Название:</span>
            <div class="form__input-container">
                <input class="form__input" type="text" name="AddTaskForm[title]">
            </div>
        </div>
        <div class="form__field">
            <span class="form__label">Текст:</span>
            <div class="form__input-container">
                <textarea class="form__textarea" name="AddTaskForm[text]" rows="10" spellcheck="false"></textarea>
            </div>
        </div>
        <button class="form__button">Добавить</button>
    </form>
</div>