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
            treeList: []
        }
    },
    computed: {
        listedGroups: function() {
            // Подготавливаем объекты групп
            for (var id in this.groups) this.$set(this.groups[id], 'list', []);

            // Добавляем итемы первого поколения в группы
            for (var i = 0; i < this.treeList.length; ++i) {
                var parentItem = this.treeList[i];
                this.groups[parentItem.groupId].list.push(parentItem);
            }

            // Возвращать все время this.groups нельзя - Vue будет видеть что это
            // всегда один и тот же объект и зависящие от listedGroups части не
            // будут обновляться. Поэтому будем всегда возвращать копию this.groups. 
            return {...this.groups};
        }
    },
    mounted: function() {
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
            $.ajax({
                url: this.store.groups.links.getAdd(this.projectId),
                success: (data) => {
                    data = JSON.parse(data);
                    let newGroups = {};
                    newGroups[data.id] = {
                        id: data.id,
                        name: data.name,
                        colorId: data.color_id,
                        isNew: true
                    };
                    this.groups = {...this.groups, ...newGroups };
                }
            });
        },
        deleteGroup: function(groupId) {
            // Удаляем из БД
            $.ajax({ url: this.store.groups.links.getDelete(groupId) });

            // Удаляем из JS
            var groups = {};
            for (var id in this.groups) if (id != groupId) groups[id] = this.groups[id];
            this.groups = groups;
        }
    }
};
</script>