<?php

use yii\helpers\Url;

/** @var \app\models\Project $project */
/** @var array $issues */
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section"><?= $project->name ?></span>
</div>
<div class="box" id="todo-app">
    <div class="todo-list-tabs">
        <button class="todo-list-tabs__item" @click="todo = 'all'" :class="{ 'todo-list-tabs__item--active': todo == 'all' }">Все</button>
        <button class="todo-list-tabs__item" @click="todo = 'undone'" :class="{ 'todo-list-tabs__item--active': todo == 'undone' }">Активные</button>
        <button class="todo-list-tabs__item" @click="todo = 'done'" :class="{ 'todo-list-tabs__item--active': todo == 'done' }">Выполненные</button>
    </div>
    <div class="todo-group">
        <span class="todo-group__title">Общее</span>
        <contextmenu class="todo-contextmenu">
            <span class="todo-contextmenu__item" id="change-color"><i class="icon paint brush"></i>Изменить цвет</span>
            <span class="todo-contextmenu__item"><i class="icon pencil alternate"></i>Изменить название</span>
            <a href="<?= Url::to(['/todo/add-item', 'project' => $project->id]) ?>" class="todo-contextmenu__item"><i class="icon add"></i>Добавить задачу</a>
            <span class="todo-contextmenu__item"><i class="icon trash"></i>Удалить группу</span>
        </contextmenu>
        <contextmenu class="todo-contextmenu todo-contextmenu--grid" for="change-color" on="click">
            <div class="todo-contextmenu__item" style="background: #F14C4C"></div>
            <div class="todo-contextmenu__item" style="background: #F8A13F"></div>
            <div class="todo-contextmenu__item" style="background: #75C181"></div>
            <div class="todo-contextmenu__item" style="background: #4192C1"></div>
        </contextmenu>
    </div>
    <todo-list 
        class="todo-list--parent"
        :mode="todo"
        :list="treeList"
        @load="list = [<?php foreach ($issues as $issue): ?>{
            id: <?=$issue->id?>,
            number: <?=$issue->number?>,
            title: '<?=str_replace('&#039;', '\&#039;', $issue->title)?>', 
            parentId: <?=$issue->parent_issue_id ? $issue->parent_issue_id : 0 ?>, 
            checked: <?= $issue->checked ? 'true' : 'false' ?>
        },<?php endforeach ?>]; token = '<?= Yii::$app->request->csrfToken ?>'; todo = 'undone'"
        @item-toggled="itemToggled">
    </todo-list>
</div>