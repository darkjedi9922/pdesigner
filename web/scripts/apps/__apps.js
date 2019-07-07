import setupApp from './../create-vue-app'
import EditTaskForm from './../components/EditTaskForm';
import AddTaskForm from './../components/AddTaskForm';
import EditProjectForm from './../components/EditProjectForm';
import AddProjectForm from './../components/AddProjectForm';
import IssueApp from './../components/IssueApp';

setupApp(EditTaskForm, '#edit-task-form-app', global._editTaskFormAppOuterData);
setupApp(AddTaskForm, '#add-task-form-app', global._addTaskFormAppOuterData);
setupApp(EditProjectForm, '#edit-project-form-app', global._editProjectFormAppData);
setupApp(AddProjectForm, '#add-project-form-app', global._addProjectFormAppData);
setupApp(IssueApp, '#issue-app', global._issueAppData);