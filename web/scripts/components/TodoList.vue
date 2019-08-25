<template lang="html">
    <div>
        <div class="todo-list" v-if="filteredList.length !== 0">
            <todo-list-item
                v-for="item in filteredList"
                v-if="item.parentId == parentItemId"
                v-bind="item"
                :key="item.id"
                @status-changed="applyItemStatus(item.id, $event.status)"
                @removed="removeItem(item.id)"
                :data-item-id="item.id"
            >
                <todo-list
                    slot="sublist"
                    class="todo-item__sublist"
                    v-if="item.filteredChildren.length !== 0"
                    :list="item.filteredChildren"
                    :parentItemId="item.id"
                    :mode="mode"
                    @status-applied="throwStatusAppliedEvent"
                    @item-removed="throwItemRemovedEvent">
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
import { IssueStatus, findStatusById } from '../models';

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
                var statusDetails = IssueStatus[findStatusById(sublist[i].status)];
                if (filteredChildren.length !== 0 || statusDetails.checked === isChecked || isChecked === undefined) {
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
            this.$emit('status-applied', { itemId, status });

            // Если скрывать не нужно, выходим
            var statusDetails = IssueStatus[findStatusById(status)];
            if (this.mode === 'all' || 
                this.mode === 'done' && statusDetails.checked || 
                this.mode === 'undone' && !statusDetails.checked
            ) {
                checkInList.call(this);
                return;
            }

            // Иначе ищем жертву скрытия (если она есть)
            var item = $(this.$el).find('[data-item-id=' + itemId + ']').first();
            var closestItem = this.closestFilledItem(item, statusDetails.checked);
            if (closestItem) $(closestItem).animate({ 'height': 0 }, 250, '', checkInList.bind(this));
            else checkInList.call(this);
        },
        /**
         * Содержит ли заданный item-элемент детей, которые имеют checked
         * соответственно заданному аргументу.
         */
        itemHasChildren: function(element, checked: boolean) {
            var children = $(element).find(checked ? '.todo-item.todo-item--checked' : '.todo-item:not(.todo-item--checked)');
            if (children.length !== 0) return true;
            else return false;
        },
        /**
         * Возвращает прямого item-родителя заданного элемента. При этом если его 
         * checked не соотвествует заданному, вернет false.
         */
        itemHasParent: function(element, checked: boolean) {
            var parent = $(element).parent().closest('.todo-item')[0];
            if (parent && $(parent).hasClass('todo-item--checked') === checked) return parent;
            else return false;
        },
        /**
         * Находит ближайший полностью заполненный одинаковыми checked детьми.
         * Это либо заданный элемент-item, либо один из его родителей. При этом, 
         * может вернуть null, если текущий элемент содержит "обратных" детей.
         */
        closestFilledItem: function(element, checked: boolean) {
            if (this.itemHasChildren(element, !checked)) return null;
            var parent = this.itemHasParent(element, checked);
            if (parent && !this.itemHasChildren(parent, !checked)) return this.closestFilledItem(parent, checked);
            else return element;
        },
        throwStatusAppliedEvent: function(event) {
            this.$emit('status-applied', event);
        },
        removeItem: function(id: number): void {
            this.$emit('item-removed', { id });
        },
        throwItemRemovedEvent: function(event) {
            this.$emit('item-removed', event);
        }
    }
}
</script>