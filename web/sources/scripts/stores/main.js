;var mainStore = {
    tasks: {
        links: {
            getPage: function (taskId) { return '/todo?id=' + taskId },
            getToggle: function() { return '/todo/toggle' },
            getAddSubtask: function (parentId) { return '/todo/add-item?parent=' + parentId },
            getEdit: function (taskId) { return '/todo/edit-item?id=' + taskId },
            getDelete: function (taskId) { return '/todo/delete?id=' + taskId }
        }
    },
};