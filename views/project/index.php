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
    <div class="desk" id="app">
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
            <todo-list :mode="todo" :list="list"></todo-list>
            <!--<button @click="add">Добавить</button>-->
        </div>
    </div>
</div>