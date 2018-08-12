;var mainStore = {
    tasks: {
        links: {
            getPage: function (id) { return '/todo?id=' + id },
            getToggle: function() { return '/todo/toggle' },
            getAddSubtask: function (parentId) { return '/todo/add-item?parent=' + parentId },
            getEdit: function (id) { return '/todo/edit-item?id=' + id },
            getDelete: function (id) { return '/todo/delete?id=' + id }
        }
    },
};