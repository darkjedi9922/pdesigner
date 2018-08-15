;new Vue({ 
    el: "#todo-app",
    mixins: [taskMixin],
    data: {
        store: mainStore,
        todo: 'all',
        list: [],
        token: '',
        treeList: []
    },
    mounted: function() {
        this._setTreeList();
    },
    methods: {
        _setTreeList: function() {
            if (this.groups.length !== 0) {
                this.treeList = this.getTreeList(this.list, 0);

                /*for (var i = 0; i < this.treeList.length; ++i) {
                    var item = this.treeList[i];
                    var groupId = item.groupId;
                    if (this.groups[groupId].list === undefined) this.groups[groupId].list = [];
                    this.groups[groupId].list.push(item);
                }*/
            }
        },
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
            this.removeItemFromDb(id);
            this.treeList = this.removeItemFromList(this.treeList, id);
        },
        removeItemFromDb(itemId) {
            var itemsToDelete = this.findItemsIdToDelete(itemId, []);
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
        findItemsIdToDelete(parentItemId, array) {
            // добавляем в массив своих детей
            for (var i = 0; i < this.list.length; ++i) {
                if (this.list[i].parentId === parentItemId) this.findItemsIdToDelete(this.list[i].id, array);
            }
            // добавляем себя
            array.push(parentItemId);
            return array;
        }
    }
});