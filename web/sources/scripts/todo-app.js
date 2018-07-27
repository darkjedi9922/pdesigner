;new Vue({ 
    el: "#todo-app",
    data: {
        todo: 'undone',
        list: [],
        token: ''
    },
    methods: {
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
            // Делаем запрос в БД на удаление
            $.ajax({
                url: '/web/index.php?r=todo/delete',
                method: 'POST',
                data: 'id=' + id
                    + '&_csrf=' + this.token
            });

            // Удаляем из DOM
            var newList = [];
            for (var i = 0; i < this.list.length; ++i) {
                if (this.list[i].id !== id) newList.push(this.list[i]);
            }
            this.list = newList;
        }
    }
});