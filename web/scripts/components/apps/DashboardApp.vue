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
                    :tasks="project.tasks"
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
        projects: Array
    }
});

@Component({
    components: { ProjectActiveTasksBoard }
})
export default class DashboardApp extends DashboardAppProps {}
</script>