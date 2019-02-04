import setupApp from './../create-vue-app'
import EditTaskForm from './EditTaskForm.vue';
import AddTaskForm from './AddTaskForm.vue';

setupApp(EditTaskForm, '#edit-task-form-app', global._editTaskFormAppOuterData);
setupApp(AddTaskForm, '#add-task-form-app', global._addTaskFormAppOuterData);