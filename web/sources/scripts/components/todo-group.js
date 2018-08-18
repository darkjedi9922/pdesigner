;Vue.component('todo-group', {
    props: {
        data: Object
    },
    data: function() {
        return {
            store: mainStore
        }
    },
    template: `
        <div class="todo-group">
            <span class="todo-group__title">{{ data.name }}</span>
            <contextmenu class="todo-contextmenu">
                <span class="todo-contextmenu__item" id="change-color"><i class="icon paint brush"></i>Изменить цвет</span>
                <span class="todo-contextmenu__item"><i class="icon pencil alternate"></i>Изменить название</span>
                <a :href="store.groups.links.getAddTask(data.id)" class="todo-contextmenu__item"><i class="icon add"></i>Добавить задачу</a>
                <span class="todo-contextmenu__item"><i class="icon trash"></i>Удалить группу</span>
            </contextmenu>
            <contextmenu class="todo-contextmenu todo-contextmenu--grid" for="change-color" on="click">
                <div class="todo-contextmenu__item" style="background: #F14C4C"></div>
                <div class="todo-contextmenu__item" style="background: #F8A13F"></div>
                <div class="todo-contextmenu__item" style="background: #75C181"></div>
                <div class="todo-contextmenu__item" style="background: #4192C1"></div>
            </contextmenu>
        </div>
    `
});