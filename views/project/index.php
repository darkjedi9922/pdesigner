<?php

use app\models\Issue;

$issues = Issue::find()->all();
?>

<div class="container">
    <div class="menu" id="menu">
        <div class="item opened">
            <span class="header"><i class="folder icon"></i>Проекты<i class="caret up icon"></i><i class="caret down icon"></i></span>
            <div class="content">
                <a href="#" class="item">Lightness</a>
                <a href="#" class="item">Добавить проект</a>
            </div>
        </div>
        <div class="item opened">
            <span class="header"><i class="address card icon"></i>Профиль<i class="caret up icon"></i><i class="caret down icon"></i></span>
            <div class="content">
                <a href="#" class="item">Настройки</a>
            </div>
        </div>
    </div>
    <div class="desk" id="todo-app">
        <div class="breadcrumb">
            <span class="breadcrumb__section">Проекты</span>
            <span class="breadcrumb__divisor"></span>
            <span class="breadcrumb__section">Lightness</span>
        </div>
        <div class="box">
            <div class="todo-list-tabs">
                <button class="todo-list-tabs__item" @click="todo = 'all'" :class="{ 'todo-list-tabs__item--active': todo == 'all' }">Все</button>
                <button class="todo-list-tabs__item" @click="todo = 'undone'" :class="{ 'todo-list-tabs__item--active': todo == 'undone' }">Активные</button>
                <button class="todo-list-tabs__item" @click="todo = 'done'" :class="{ 'todo-list-tabs__item--active': todo == 'done' }">Выполненные</button>
            </div>
            <todo-list 
                :mode="todo"
                :list="list"
                @load="list = [<?php foreach ($issues as $issue): ?>{
                id: <?=$issue->id?>,
                number: <?=$issue->number?>,
                title: '<?=$issue->title?>', 
                parentId: <?=$issue->{'parent_issue_id'} ? $issue->{'parent_issue_id'} : 0 ?>, 
                checked: <?= $issue->checked ? 'true' : 'false' ?>
            },<?php endforeach ?>]"
                @item-toggled="itemToggled">
            </todo-list>
            <br><button class="todo-list__button" @click="add">Добавить задачу</button>
        </div>
    </div>
</div>