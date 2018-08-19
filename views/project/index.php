<?php

use yii\helpers\Url;

/** @var \app\models\Project $project */
/** @var \app\models\ProjectDescription|null $desc */
/** @var array $issues */
/** @var array $groups */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section"><?= $project->name ?></span>
</div>
<div class="boxes">
    <div class="boxes__item boxes__item--main">
        <?php if ($desc): ?>
        <div class="box" id="project-desc-app">
            <span class="project__desc"><?= str_replace("\n", '<br>', $desc->description) ?></span>
        </div>
        <?php endif ?>
        <div class="box" id="todo-app">
            <vue-app-init @before-mount="
                projectId = <?= $project->id ?>;
                list = [<?php foreach ($issues as $issue) : ?>{
                    id: <?= $issue->id ?>,
                    number: <?= $issue->number ?>,
                    title: '<?= str_replace('&#039;', '\&#039;', $issue->title) ?>', 
                    parentId: <?= $issue->parent_issue_id ? $issue->parent_issue_id : 0 ?>,
                    groupId: <?= $issue->group_id ?>, 
                    checked: <?= $issue->checked ? 'true' : 'false' ?>
                },<?php endforeach ?>]; 
                groups = {<?php foreach ($groups as $group) : ?>
                <?= $group->id ?>: {
                    id: <?= $group->id ?>,
                    name: '<?= str_replace('&#039;', '\&#039;', $group->name) ?>',
                    colorId: <?= $group->color_id ?>
                },<?php endforeach ?>};
                token = '<?= Yii::$app->request->csrfToken ?>'; 
                mode = 'undone';
            "></vue-app-init>
            <div class="todo-list-tabs">
                <button class="todo-list-tabs__item" @click="mode = 'all'" :class="{ 'todo-list-tabs__item--active': mode == 'all' }">Все</button>
                <button class="todo-list-tabs__item" @click="mode = 'undone'" :class="{ 'todo-list-tabs__item--active': mode == 'undone' }">Активные</button>
                <button class="todo-list-tabs__item" @click="mode = 'done'" :class="{ 'todo-list-tabs__item--active': mode == 'done' }">Выполненные</button>
            </div>
            <vue-todo
                :listed-groups="listedGroups"
                :mode="mode"
            ></vue-todo>
            <button class="form__button" @click="addGroup">Добавить группу</button>
        </div>
    </div>
    <div class="boxes__item">
        <div class="box">
            <div class="task-toolbar task-toolbar--vertical">
                <a href="<?= Url::to(['/project/edit', 'id' => $project->id]) ?>" class="task-toolbar__button">Редактировать проект</a>
                <a href="<?= Url::to(['/project/delete', 'id' => $project->id]) ?>" class="task-toolbar__button task-toolbar__button--bad">Удалить проект</a>
            </div>
        </div>
    </div>
</div>