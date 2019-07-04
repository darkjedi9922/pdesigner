import Vue from 'vue';
import $ from 'jquery';
import TodoListItem from './TodoListItem';

Vue.component('todo-list', {
    components: { TodoListItem },
    props: {
        list: {
            type: Array,
            required: false,
            default: function() { return [] }
        },
        parentItemId: {
            type: Number,
            required: false,
            default: 0
        },
        mode: {
            // значения: 'all', 'done', 'undone'
            type: String,
            required: false,
            default: 'all'
        }
    },
    mounted: function() {
        this.$emit('load');
    },
    computed: {
        filteredList: function() {
            if (this.mode == 'done') return this.getFilteredSublist(this.list, true);
            else if (this.mode == 'undone') return this.getFilteredSublist(this.list, false);
            else return this.getFilteredSublist(this.list, undefined);
        }
    },
    methods: {
        getFilteredSublist: function(sublist, isChecked) {
            var list = [];
            for (var i = 0; i < sublist.length; ++i) {
                var filteredChildren = this.getFilteredSublist(sublist[i].children, isChecked);
                if (filteredChildren.length !== 0 || sublist[i].checked === isChecked || isChecked === undefined) {
                    sublist[i].filteredChildren = filteredChildren;
                    list.push(sublist[i]);
                };
            }
            return list;
        },
        itemToggled: function($event) {
            var checkInList = function() {
                for (var i = 0; i < this.list.length; ++i) {
                    if (this.list[i].id === $event.id) this.list[i].checked = $event.checked;
                }
            }

            // отправлям событие
            this.$root.itemToggled($event);

            // Если скрывать не нужно, выходим
            if (this.mode === 'all' || this.mode === 'done' && $event.checked || this.mode === 'undone' && !$event.checked) {
                checkInList.call(this);
                return;
            }

            // Иначе ищем жертву скрытия (если она есть)
            var item = this.closestFilledItem($event.el, $event.checked);
            if (item) $(item).animate({ 'height': 0 }, 250, '', checkInList.bind(this));
            else checkInList.call(this);
        },
        /**
         * Содержит ли заданный item-элемент детей, которые checked/unchecked соответственно заданному аргументу.
         */
        itemHasChildren: function(element, checked) {
            var children = $(element).find(checked ? '.todo-item.todo-item--checked' : '.todo-item:not(.todo-item--checked)');
            if (children.length !== 0) return true;
            else return false;
        },
        /**
         * Возвращает прямого item-родителя заданного элемента. При этом если его checked не соотвествует.
         * заданному, вернет false.
         */
        itemHasParent: function(element, checked) {
            var parent = $(element).parent().closest('.todo-item')[0];
            if (parent && $(parent).hasClass('todo-item--checked') === checked) return parent;
            else return false;
        },
        /**
         * Находит ближайший полностью заполненный одинаковыми checked/unchecked детьми.
         * Это либо заданный элемент-item, либо один из его родителей. При этом, может вернуть null,
         * если текущий элемент содержит "обратных" детей.
         */
        closestFilledItem: function(element, checked) {
            if (this.itemHasChildren(element, !checked)) return null;
            var parent = this.itemHasParent(element, checked);
            if (parent && !this.itemHasChildren(parent, !checked)) return this.closestFilledItem(parent, checked);
            else return element;
        }
    },
    template: '\
        <div>\
            <div\
                class="todo-list"\
                v-if="filteredList.length !== 0">\
\
                <todo-list-item\
                    v-for="item in filteredList"\
                    v-if="item.parentId == parentItemId"\
                    v-bind="item"\
                    :key="item.id"\
                    v-on:toggle="itemToggled">\
\
                    <todo-list\
                        slot="sublist"\
                        class="todo-item__sublist"\
                        v-if="item.filteredChildren.length !== 0"\
                        :list="item.filteredChildren"\
                        :parentItemId="item.id"\
                        :mode="mode"\
                        v-on:item-toggled="$emit(\'item-toggled\', $event)">\
                    </todo-list>\
\
                </todo-list-item>\
\
            </div>\
            <span v-else class="todo-list__message">Список пуст</span>\
        </div>\
    '
});