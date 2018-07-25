;Vue.component('todo-list', {
    props: {
        list: {
            type: Array,
            required: false,
            default: []
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
        },
        tree: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    computed: {
        filteredList: function() {
            if (this.mode == 'done') return this.getFilteredSublist(this.treeList, true);
            else if (this.mode == 'undone') return this.getFilteredSublist(this.treeList, false);
            else return this.treeList;
        },
        treeList: function() {
            this.mode; // Зависимость treeList от mode: treeList будет пересчитываться каждый раз при изменении mode
            return this.tree ? this.list : this.getTreeList(this.parentItemId);
        }
    },
    methods: {
        getTreeList: function(parentItemId) {
            var list = [];
            for (var i = 0; i < this.list.length; ++i) {
                if (this.list[i].parentId === parentItemId) {
                    this.list[i].children = this.getTreeList(this.list[i].id);
                    list.push(this.list[i]);
                }
            }
            return list;
        },
        getFilteredSublist: function(sublist, isChecked) {
            var list = [];
            for (var i = 0; i < sublist.length; ++i) {
                var filteredChildren = this.getFilteredSublist(sublist[i].children, isChecked);
                if (filteredChildren.length !== 0 || sublist[i].checked == isChecked) {
                    sublist[i].children = filteredChildren;
                    list.push(sublist[i]);
                };
            }
            return list;
        },
        itemToggled: function($event) {
            var checkInList = function() {
                for (var i = 0; i < this.treeList.length; ++i) {
                    if (this.treeList[i].id === $event.id) this.treeList[i].checked = $event.checked;
                }
            }

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
                        v-if="item.children.length !== 0"\
                        :list="item.children"\
                        :parentItemId="item.id"\
                        :mode="mode"\
                        tree>\
                    </todo-list>\
\
                </todo-list-item>\
\
            </div>\
            <span v-else class="todo-list__message">Список пуст</span>\
        </div>\
    '
});