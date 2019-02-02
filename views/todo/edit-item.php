<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\models\Issue $item */
/** @var \app\models\Project $project */
/** @var string $text */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="<?= Url::to(['/project', 'id' => $project->id]) ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Редактировать задачу</span>
</div>
<div class="box">
    <div class="form__content">
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
        </div>
        <div class="form__preview">
            Бла бла бла еще бла бла бла бла бла
        </div>
        <button class="form__button">Сохранить</button>
    </form>
</div>