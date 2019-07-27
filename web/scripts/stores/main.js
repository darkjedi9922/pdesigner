export default {
    tasks: {
        links: {
            getPage: function (taskId) { return '/todo?id=' + taskId },
            getToggle: function() { return '/todo/item/toggle' },
            getAddSubtask: function (parentId) { return '/todo/item/add?parent=' + parentId },
            getEdit: function (taskId) { return '/todo/item/edit?id=' + taskId },
            getDelete: function (taskId) { return '/todo/item/delete?id=' + taskId }
        }
    },
    groups: {
        links: {
            getAddTask: function(groupId) { return '/todo/item/add?group=' + groupId },
            setColorId: function(groupId, colorId) { return '/todo/group/set-color?group=' + groupId + '&color=' + colorId },
            setName: function(groupId, name) { return '/todo/group/set-name?group=' + groupId + '&name= ' + name },
            getAdd: function(projectId) { return '/todo/group/add?project=' + projectId },
            getDelete: function(groupId) { return '/todo/group/delete?group=' + groupId }
        }
    }
};
