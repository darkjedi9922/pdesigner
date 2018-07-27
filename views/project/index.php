<?php

use app\models\Issue;

$issues = Issue::find()->orderBy('id ASC')->all();
?>

<div class="breadcrumb">
    <span class="breadcrumb__section">Проекты</span>
    <span class="breadcrumb__divisor"></span>
    <span class="breadcrumb__section">Lightness</span>
</div>
<div class="box" id="todo-app">
    <div class="todo-list-tabs">
        <button class="todo-list-tabs__item" @click="todo = 'all'" :class="{ 'todo-list-tabs__item--active': todo == 'all' }">Все</button>
        <button class="todo-list-tabs__item" @click="todo = 'undone'" :class="{ 'todo-list-tabs__item--active': todo == 'undone' }">Активные</button>
        <button class="todo-list-tabs__item" @click="todo = 'done'" :class="{ 'todo-list-tabs__item--active': todo == 'done' }">Выполненные</button>
    </div>
    <todo-list 
        class="todo-list--parent"
        :mode="todo"
        :list="list"
        @load="list = [<?php foreach ($issues as $issue): ?>{
        id: <?=$issue->id?>,
        number: <?=$issue->number?>,
        title: '<?=$issue->title?>', 
        parentId: <?=$issue->parent_issue_id ? $issue->parent_issue_id : 0 ?>, 
        checked: <?= $issue->checked ? 'true' : 'false' ?>
    },<?php endforeach ?>]; token = '<?= Yii::$app->request->csrfToken ?>'"
        @item-toggled="itemToggled">
    </todo-list>
    <br><a href="/web/index.php?r=todo/add-item" class="todo-list__button">Добавить задачу</a>
</div>