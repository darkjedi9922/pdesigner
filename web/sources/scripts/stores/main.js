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
    groups: {
        links: {
            getAddTask: function(groupId) { return '/todo/add-item?group=' + groupId },
            setColorId: function(groupId, colorId) { return '/todo/group/set-color?group=' + groupId + '&color=' + colorId },
            setName: function(groupId, name) { return '/todo/group/set-name?group=' + groupId + '&name= ' + name }
        }
    }
};
