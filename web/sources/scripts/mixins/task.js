var taskMixin = {
    methods: {
        setTaskChecked(id, checked, token) {
            $.ajax({
                url: '/web/index.php?r=todo/toggle',
                method: 'POST',
                data: 'id=' + id
                    + '&checked=' + +checked
                    + '&_csrf=' + token
                // TODO: красиво выводить красивую ошибку при ошибке
            });
        }
    }
}