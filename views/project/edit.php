<?php

use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Project $project */
/** @var app\models\ProjectDescription|null $desc */

?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="<?= Url::to(['/project', 'id' => $project->id]) ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
</div>
<div class="box">
    <form method="post">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <div class="form">
            <div class="form__content">
                <div class="form__field">
                    <span class="form__label">Название:</span>
                    <div class="form__input-container">
                        <input type="text" class="form__input" name="EditProjectForm[name]" spellcheck="false" value="<?= $project->name ?>">
                    </div>
                </div>
                <div class="form__field">
                    <span class="form__label">Описание:</span>
                    <div class="form__input-container">
                        <textarea class="form__textarea" name="EditProjectForm[description]" rows="10" spellcheck="false"><?php if ($desc) echo $desc->description ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <br><button class="form__button">Сохранить</button>
    </form>
</div>