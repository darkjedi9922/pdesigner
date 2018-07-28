;Vue.component('todo-list-item', {
    props: {
        id: Number,
        number: Number,
        title: String,
        parentId: Number,
        checked: Boolean
    },
    data: function() {
        return {
            isChecked: this.checked
        }
    },
    methods: {
        toggle: function() {
            this.isChecked = !this.isChecked;
            this.$nextTick(function() {
                this.$emit('toggle', {
                    el: this.$el,
                    id: this.id,
                    checked: this.isChecked
                });
            });
        }
    },
    template: '\
        <div class="todo-item" :class="{ \'todo-item--checked\': isChecked }">\
            <div class="todo-item__container">\
                <contextmenu class="todo-contextmenu">\
                    <a :href="\'/web/index.php?r=todo/add-item&parent=\' + id" class="todo-contextmenu__item"><i class="icon add"></i>Добавить позадачу</a>\
                    <a :href="\'/web/index.php?r=todo/edit-item&id=\' + id" class="todo-contextmenu__item"><i class="icon edit"></i>Редактировать</a>\
                    <a @click="$root.deleteItem(id)" class="todo-contextmenu__item"><i class="icon delete"></i>Удалить</a>\
                </contextmenu>\
                <vue-checkbox class="todo-item__checkbox" :checked="isChecked" v-on:toggle="toggle">\
                    <a href="#" class="todo-item__label" :class="{ \'todo-item__label--checked\': isChecked }">#{{ number }} {{ title }}</a>\
                </vue-checkbox>\
            </div>\
            <slot name="sublist"></slot>\
        </div>\
    '
});