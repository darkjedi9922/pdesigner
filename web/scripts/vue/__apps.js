import setupApp from './../create-vue-app'
import EditTaskForm from './EditTaskForm.vue';
import AddTaskForm from './AddTaskForm.vue';
import EditProjectForm from './EditProjectForm.vue';
import AddProjectForm from './AddProjectForm.vue';

setupApp(EditTaskForm, '#edit-task-form-app', global._editTaskFormAppOuterData);
setupApp(AddTaskForm, '#add-task-form-app', global._addTaskFormAppOuterData);
setupApp(EditProjectForm, '#edit-project-form-app', global._editProjectFormAppData);
setupApp(AddProjectForm, '#add-project-form-app', global._addProjectFormAppData);