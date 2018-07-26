;new Vue({ 
    el: "#todo-app",
    data: {
        todo: 'undone',
        list: [],
        newId: 1,
        newNumber: 1
    },
    mounted: function() {
        var maxId = 1;
        var maxNumber = 1;
        for (var i = 0; i < this.list.length; ++i) {
            if (this.list[i].id > maxId) maxId = this.list[i].id;
            if (this.list[i].number > maxNumber) maxNumber = this.list[i].number;
        }
        this.newId = ++maxId;
        this.newNumber = ++maxNumber;
    },
    methods: {
        add: function() {
            // в будущем БД будет возвращать id и number
            var id = this.newId++;
            var number = this.newNumber++;
            this.list.push({
                id: id,
                number: number,
                title: 'Новый итем',
                parentId: 0,
                checked: false
            });
        },
        itemToggled: function($event) {
            $.ajax({
                url: '/web/index.php?r=todo/toggle',
                method: 'POST',
                data: 'id=' + $event.id + '&checked=' + +$event.checked
                // TODO: красиво выводить красивую ошибку при ошибке
            });
        }
    }
});