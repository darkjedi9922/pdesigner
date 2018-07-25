;Vue.component('todo-list-item', {
    props: {
        id: Number,
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

            // Vue не успевает обновить класс элемента к моменту выброса события
            // Поэтому фикс с timeout:
            var emit = function() {
                if ($(this.$el).hasClass('todo-item--checked') === this.isChecked) {
                    // Основная часть началась
                    this.$emit('toggle', {
                        el: this.$el,
                        id: this.id,
                        checked: this.isChecked
                    });
                    // Основная часть закончилась
                } else setTimeout(emit.bind(this), 50);
            }
            emit.call(this);
        }
    },
    template: '\
        <div class="todo-item" :class="{ \'todo-item--checked\': isChecked }">\
            <div class="todo-item__container">\
                <vue-checkbox class="todo-item__checkbox" :checked="isChecked" v-on:toggle="toggle">\
                    <a href="#" class="todo-item__label" :class="{ \'todo-item__label--checked\': isChecked }">#{{ id }} {{ title }}</a>\
                </vue-checkbox>\
            </div>\
            <slot name="sublist"></slot>\
        </div>\
    '
});