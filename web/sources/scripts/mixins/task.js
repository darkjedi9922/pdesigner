var taskMixin = {
    data: function() {
        return {
            store: mainStore
        }
    },
    methods: {
        setTaskChecked(id, checked, token) {
            $.ajax({
                url: this.store.tasks.links.getToggle(),
                method: 'POST',
                data: 'id=' + id
                    + '&checked=' + +checked
                    + '&_csrf=' + token
                // TODO: красиво выводить красивую ошибку при ошибке
            });
        }
    }
}