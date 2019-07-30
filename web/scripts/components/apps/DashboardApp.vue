<template>
    <div class="dashboard">
        <div class="dashboard__main">
            <div class="board">
                <div class="board__title">Активные задачи</div>
                <project-active-tasks-board
                    v-for="project in projects"
                    :key="project.id"
                    :name="project.name"
                    :description="project.description"
                    :tasks="filterTasks(project.id)"
                    :groups="groups"
                ></project-active-tasks-board>
            </div>
        </div>
        <div class="dashboard__second">
            <div class="board">
                <div class="board__title">Профиль</div>
                <div class="subboard">{{ username }}</div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
import Component from 'vue-class-component';
import ProjectActiveTasksBoard from '../ProjectActiveTasksBoard';

const DashboardAppProps = Vue.extend({
    props: {
        username: String,
        projects: Object,
        groups: Object,
        tasks: Object
    }
});

@Component({
    components: { ProjectActiveTasksBoard }
})
export default class DashboardApp extends DashboardAppProps {
    filterTasks(projectId: number): object {
        let result = {};
        for (const id in this.tasks) {
            if (this.tasks.hasOwnProperty(id)) {
                const task = this.tasks[id];
                if (task.projectId === projectId) result[id] = task;
            }
        }
        return result;
    }
}
</script>