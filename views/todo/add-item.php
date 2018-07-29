<?php

/** @var \yii\web\View $this */
/** @var \app\models\Issue|null $parent */
/** @var \app\models\Project $project */

?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="/web/index.php?r=project&id=<?= $project->id ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Добавить задачу</span>
</div>
<div class="box">
    <?php if ($parent) : ?>
        <div class="form__field">
            <span class="form__label">Задача: <?= $parent->title ?></span>
        </div>
    <?php endif ?>
    <form method="post" class="form form--table">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <?php if ($parent): ?><input type="hidden" name="AddTaskForm[parent]" value="<?= $parent->id ?>"><?php endif ?>
        <input type="hidden" name="AddTaskForm[project]" value="<?= $project->id ?>">
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