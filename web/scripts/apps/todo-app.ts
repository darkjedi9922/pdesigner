import Vue, { VueConstructor } from 'vue';
import taskMixin from '../mixins/task';
import mainStore from '../stores/main';
import VueAppInit from '../components/vue-app-init';
import VueTodo from  '../components/vue-todo';
import $ from 'jquery';
import { IssueStatus } from "../models";

new Vue({ 
    el: "#todo-app",
    mixins: [taskMixin],
    components: {
        VueAppInit,
        VueTodo
    },
    data: {
        // props
        projectId: null,
        list: [],
        mode: 'all',
        groups: {},
        token: '',
        // other data
        store: mainStore,
        treeList: []
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
            return this.groups;
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
        itemToggled: function($event) {
            this.setTaskStatus($event.id, $event.checked, this.token);
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
            var self = this;
            $.ajax({
                url: this.store.groups.links.getAdd(this.projectId),
                success: function(data) {
                    data = JSON.parse(data);
                    self.$set(self.groups, data.id, {
                        id: data.id,
                        name: data.name,
                        colorId: data.color_id,
                        isNew: true
                    });
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
});