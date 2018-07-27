;new Vue({ 
    el: "#todo-app",
    data: {
        todo: 'undone',
        list: [],
        token: '',
        treeList: []
    },
    mounted: function() {
        this.treeList = this.getTreeList(0);
    },
    watch: {
        todo: function() {
            this.treeList = this.getTreeList(0);
        },
        list: function() {
            this.treeList = this.getTreeList(0);
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
        itemToggled: function($event) {
            $.ajax({
                url: '/web/index.php?r=todo/toggle',
                method: 'POST',
                data: 'id=' + $event.id 
                    + '&checked=' + +$event.checked
                    + '&_csrf=' + this.token
                // TODO: красиво выводить красивую ошибку при ошибке
            });
        },
        deleteItem: function(id) {
            /**
             * Сначала я рекурсивно удалял всех детей, вызывая этот метод.
             * Но оказалось, что в БД в итоге иногда удалялись не все итемы.
             * Некоторые AJAX запросы просто исчезали. Скорей всего это из-за
             * того, что каждый раз при удалении одного из итемов, переопределялся
             * новый список для удаления итемов из DOM, а он ведь реактивный и Vue, 
             * как всегда, в своем отдельном потоке что-то где-то неуспевал.
             * 
             * Поэтому было решено сначала найти все итемы для удаления, а уже потом
             * линейно пройтись по ним циклом, удалить их в нем, и в самом конце,
             * только один раз переопределить список. Это решило проблему.
             */

            var itemsToDelete = this.findItemsIdToDelete(id, []);

            for (var i = 0; i < itemsToDelete.length; ++i) {
                // Делаем запрос в БД на удаление
                $.ajax({
                    url: '/web/index.php?r=todo/delete',
                    method: 'POST',
                    data: 'id=' + itemsToDelete[i]
                        + '&_csrf=' + this.token
                });
            }
            
            // Удаляем из DOM
            var newList = [];
            for (var i = 0; i < this.list.length; ++i) {
                if (!itemsToDelete.includes(this.list[i].id)) newList.push(this.list[i]);
            }
            this.list = newList;
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