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
        }
    }
});