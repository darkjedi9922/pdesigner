<?php
/** @var \yii\web\View $this */
/** @var \app\models\Issue $item */
/** @var \app\models\Project $project */
/** @var string $text */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="/web/index.php?r=project&id=<?= $project->id ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Редактировать задачу</span>
</div>
<div class="box">
    <form method="post" class="form form--table">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <div class="form__field">
            <span class="form__label">Название:</span>
            <div class="form__input-container">
                <input class="form__input" type="text" name="EditTaskForm[title]" value='<?= $item->title ?>' spellcheck="false">
            </div>
        </div>
        <div class="form__field">
            <span class="form__label">Текст:</span>
            <div class="form__input-container">
                <textarea class="form__textarea" name="EditTaskForm[text]" rows="10" spellcheck="false"><?= $text ?></textarea>
            </div>
        </div>
        <button class="form__button">Сохранить</button>
    </form>
</div>