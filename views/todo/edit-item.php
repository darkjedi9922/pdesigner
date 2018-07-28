<?php
/** @var \yii\web\View $this */
/** @var \app\models\Issue $item */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="/web/index.php?r=project" class="breadcrumb__section breadcrumb__section--link">Lightness</a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Редактировать задачу</span>
</div>
<div class="box">
    <form method="post" class="form">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <div class="form__field">
            <span class="form__label">Название:</span>
            <input class="form__input" type="text" name="EditTaskForm[title]" value='<?= str_replace('&#039;', '\&#039;', $item->title) ?>'>
        </div>
        <button class="form__button">Сохранить</button>
    </form>
</div>