<template>
    <div class="box" id="todo-app">
        <div class="todo-list-tabs">
            <button class="todo-list-tabs__item" @click="mode = 'all'" :class="{ 'todo-list-tabs__item--active': mode == 'all' }">Все</button>
            <button class="todo-list-tabs__item" @click="mode = 'undone'" :class="{ 'todo-list-tabs__item--active': mode == 'undone' }">Активные</button>
            <button class="todo-list-tabs__item" @click="mode = 'done'" :class="{ 'todo-list-tabs__item--active': mode == 'done' }">Выполненные</button>
        </div>
        <vue-todo
            :listed-groups="listedGroups"
            :mode="mode"
            @status-applied="setItemStatus($event.itemId, $event.status)"
            @item-removed="deleteItem($event.id)"
            @group-removed="deleteGroup($event.id)"
        ></vue-todo>
        <button class="form__button" @click="addGroup">Добавить группу</button>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import taskMixin from '../../mixins/task';
import mainStore from '../../stores/main';
import VueTodo from  '../VueTodo';
import { AddGroupPayload } from '../../store';
import $ from 'jquery';

export default {
    mixins: [taskMixin],
    components: {
        VueTodo
    },
    props: {
        projectId: Number,
        list: Array,
        mode: String,
        groups: Object,
        token: String
    },
    data: function() {
        return {
            store: mainStore,
            treeList: [],
            theGroups: {}
        }
    },
    computed: {
        listedGroups: function() {
            // Подготавливаем объекты групп
            for (var id in this.theGroups) this.$set(this.theGroups[id], 'list', []);

            // Добавляем итемы первого поколения в группы
            for (var i = 0; i < this.treeList.length; ++i) {
                var parentItem = this.treeList[i];
                this.theGroups[parentItem.groupId].list.push(parentItem);
            }

            // Возвращать все время this.theGroups нельзя - Vue будет видеть что это
            // всегда один и тот же объект и зависящие от listedGroups части не
            // будут обновляться. Поэтому будем всегда возвращать копию this.theGroups. 
            return {...this.theGroups};
        }
    },
    mounted: function() {
        this.theGroups = this.groups;
        this.treeList = this.getTreeList(this.list, 0);
    },
    methods: {
        getTreeList: function(linerarList, parentItemId) {
            var list = [];
            for (var i = 0; i < linerarList.length; ++i) {
                if (linerarList[i].parentId === parentItemId) {
                    linerarList[i].children = this.getTreeList(linerarList, linerarList[i].id);
                    list.push(linerarList[i]);
                }
            }
            return list;
        },
        setItemStatus: function(id: number, status: number) {
            this.setTaskStatus(id, status, this.token);
        },
        deleteItem: function(id) {
            this.removeItemFromDb(this.treeList, id);
            this.treeList = this.removeItemFromList(this.treeList, id);
        },
        removeItemFromDb: function(treeList, itemId) {
            var itemsToDelete = this.findItemsIdToDelete(treeList, itemId, []);
            for (var i = 0; i < itemsToDelete.length; ++i)
                $.ajax({ url: this.store.tasks.links.getDelete(itemsToDelete[i]) });
        },
        removeItemFromList: function(treeList, itemId) {
            var list = [];
            for (var i = 0; i < treeList.length; ++i) {
                if (treeList[i].id !== itemId) {
                    treeList[i].children = this.removeItemFromList(treeList[i].children, itemId);
                    list.push(treeList[i]);
                }
            }
            return list;
        },
        findItemsIdToDelete: function(treeList, itemId, itemIds) {
            for (var i = 0; i < treeList.length; ++i) {
                var item = treeList[i];
                if (item.id === itemId) {
                    itemIds.push(item.id);
                    for (var j = 0; j < item.children.length; ++j) {
                        var child = item.children[j];
                        this.findItemsIdToDelete(item.children, child.id, itemIds);
                    }
                } else this.findItemsIdToDelete(item.children, itemId, itemIds);
            }
            return itemIds;
        },
        addGroup: function() {
            this.$store.dispatch('addGroup', <AddGroupPayload>{
                projectId: this.projectId,
                successCallback: (data) => {
                    let newGroups = {};
                    newGroups[data.id] = {
                        id: data.id,
                        name: data.name,
                        colorId: data.color_id,
                        isNew: true
                    };
                    this.theGroups = {...this.theGroups, ...newGroups };
                }
            })
        },
        deleteGroup: function(groupId) {
            // Удаляем из БД
            this.$store.dispatch('deleteGroup', groupId);

            // Удаляем из JS
            delete this.theGroups[groupId];

            // Задачи этой группы тоже нужно удалить вместе с ней
            var list = [];
            this.list.forEach(item => {
                if (item.groupId != groupId) list.push(item);
            });
            this.list = list;
            // Так как treeList это data, само оно не обновится...
            this.treeList = this.getTreeList(this.list, 0);
        }
    }
}
</script>