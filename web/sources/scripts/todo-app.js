;new Vue({ 
    el: "#todo-app",
    mixins: [taskMixin],
    data: {
        list: [], // только для инициализации извне

        store: mainStore,
        todo: 'all',
        groups: [],
        token: '',
        treeList: []
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
            this.setTaskChecked($event.id, $event.checked, this.token);
        },
        deleteItem: function(id) {
            this.removeItemFromDb(this.treeList, id);
            this.treeList = this.removeItemFromList(this.treeList, id);
        },
        removeItemFromDb(treeList, itemId) {
            var itemsToDelete = this.findItemsIdToDelete(treeList, itemId, []);
            for (var i = 0; i < itemsToDelete.length; ++i)
                $.ajax({ url: this.store.tasks.links.getDelete(itemsToDelete[i]) });
        },
        removeItemFromList(treeList, itemId) {
            var list = [];
            for (var i = 0; i < treeList.length; ++i) {
                if (treeList[i].id !== itemId) {
                    treeList[i].children = this.removeItemFromList(treeList[i].children, itemId);
                    list.push(treeList[i]);
                }
            }
            return list;
        },
        findItemsIdToDelete(treeList, itemId, itemIds) {
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
        }
    }
});