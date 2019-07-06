<template lang="html">
    <div>
        <div class="todo-list" v-if="filteredList.length !== 0">
            <todo-list-item
                v-for="item in filteredList"
                v-if="item.parentId == parentItemId"
                v-bind="item"
                :key="item.id"
                @status-changed="applyItemStatus(item.id, $event.status)"
                :data-item-id="item.id"
            >
                <todo-list
                    slot="sublist"
                    class="todo-item__sublist"
                    v-if="item.filteredChildren.length !== 0"
                    :list="item.filteredChildren"
                    :parentItemId="item.id"
                    :mode="mode">
                </todo-list>
            </todo-list-item>
        </div>
        <span v-else class="todo-list__message">Список пуст</span>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import $ from 'jquery';
import TodoListItem from './TodoListItem.vue';
import { IssueStatus } from '../models';

export default {
    name: 'todo-list',
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
            if (this.mode == 'done') return this.getFilteredSublist(this.list, IssueStatus.DONE.id);
            else if (this.mode == 'undone') return this.getFilteredSublist(this.list, IssueStatus.UNDONE.id);
            else return this.getFilteredSublist(this.list, undefined);
        }
    },
    methods: {
        getFilteredSublist: function(sublist, isChecked) {
            var list = [];
            for (var i = 0; i < sublist.length; ++i) {
                var filteredChildren = this.getFilteredSublist(sublist[i].children, isChecked);
                if (filteredChildren.length !== 0 || sublist[i].status === isChecked || isChecked === undefined) {
                    sublist[i].filteredChildren = filteredChildren;
                    list.push(sublist[i]);
                };
            }
            return list;
        },
        applyItemStatus(itemId: number, status: number): void {
            var checkInList = function() {
                for (var i = 0; i < this.list.length; ++i) {
                    if (this.list[i].id === itemId) this.list[i].status = status;
                }
            }

            // отправлям событие
            this.$root.setItemStatus(itemId, status);

            // Если скрывать не нужно, выходим
            if (this.mode === 'all' || this.mode === 'done' && status || this.mode === 'undone' && !status) {
                checkInList.call(this);
                return;
            }

            // Иначе ищем жертву скрытия (если она есть)
            var item = $(this.$el).find('[data-item-id=' + itemId + ']').first();
            var closestItem = this.closestFilledItem(item, status);
            if (closestItem) $(closestItem).animate({ 'height': 0 }, 250, '', checkInList.bind(this));
            else checkInList.call(this);
        },
        /**
         * Содержит ли заданный item-элемент детей, которые имеют status 
         * соответственно заданному аргументу.
         */
        itemHasChildren: function(element, status) {
            var children = $(element).find(status ? '.todo-item.todo-item--checked' : '.todo-item:not(.todo-item--checked)');
            if (children.length !== 0) return true;
            else return false;
        },
        /**
         * Возвращает прямого item-родителя заданного элемента. При этом если его 
         * status не соотвествует заданному, вернет false.
         */
        itemHasParent: function(element, status) {
            var parent = $(element).parent().closest('.todo-item')[0];
            if (parent && $(parent).hasClass('todo-item--checked') === status) return parent;
            else return false;
        },
        /**
         * Находит ближайший полностью заполненный одинаковыми status детьми.
         * Это либо заданный элемент-item, либо один из его родителей. При этом, 
         * может вернуть null, если текущий элемент содержит "обратных" детей.
         */
        closestFilledItem: function(element, status) {
            if (this.itemHasChildren(element, !status)) return null;
            var parent = this.itemHasParent(element, status);
            if (parent && !this.itemHasChildren(parent, !status)) return this.closestFilledItem(parent, status);
            else return element;
        }
    }
}
</script>