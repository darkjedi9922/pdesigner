<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\models\Issue $issue */
/** @var \app\models\Issue|null $parent */
/** @var \app\models\Project $project */
/** @var string $text */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <a href="<?= Url::to(['/project', 'id' => $project->id]) ?>" class="breadcrumb__section breadcrumb__section--link"><?= $project->name ?></a>
</div>
<div class="boxes">
    <div class="boxes__item boxes__item--main">
        <div class="box">
            <div class="issue" id="issue-app">
                <div class="issue__title">
                    <todo-status-icon
                        @load="
                            id = <?= $issue->id ?>;
                            status = <?= $issue->status ?>; 
                            token = '<?= Yii::$app->request->csrfToken ?>'"
                        :status="status"
                        :selectable="false">
                    </todo-status-icon>
                    <span>#<?= $issue->number ?> <?= $issue->title ?></span>
                </div>
                <?php if ($text) : ?>
                    <span class="issue__text"><?= str_replace("\n", '<br>', $text) ?></span>
                <?php endif ?>
            </div>
        </div>
    </div>
    <div class="boxes__item">
        <div class="box">
            <div class="task-toolbar task-toolbar--vertical">
                <a href="<?= Url::to(['/todo/add-item', 'parent' => $issue->id]) ?>" class="task-toolbar__button task-toolbar__button--good">Добавить подзадачу</a>
                <a href="<?= Url::to(['/todo/edit-item', 'id' => $issue->id]) ?>" class="task-toolbar__button">Редактировать</a>
                <a href="<?= Url::to(['/todo/delete', 'id' => $issue->id]) ?>" class="task-toolbar__button task-toolbar__button--bad">Удалить</a>
            </div>
        </div>
    </div>
</div>