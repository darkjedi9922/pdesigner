<template>
    <div class="subboard project-atb">
        <div class="subboard__header project-atb__header">
            <project-logo 
                class="project-atb__logo"
                :name="project.name"
            ></project-logo>
            <div class="project-atb__intro">
                <div class="project-atb__intro-first">
                    <a class="subboard__title project-atb__title" :href="'/project?id=' + project.id">{{ project.name }}</a>
                    <span class="subboard__count">{{ Object.keys(tasks).length }}</span>
                </div>
                <!-- <span class="project-atb__desc">{{ simpleDescription }}</span> -->
            </div>
        </div>
        <div class="subboard__content">
            <div 
                v-for="task in tasks"
                :key="task.id"
                class="todo-item"
            >
                <div class="todo-item__container">
                    <span :class="[
                        'todo-item__group', 
                        'todo-item__group--color-' + groups[task.groupId].colorId]"
                    >{{ groups[task.groupId].name }}</span>
                    <a 
                        :href="store.tasks.links.getPage(task.id)" 
                        class="todo-item__label"
                    ># {{ task.number }} {{ decode(task.title) }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
import Component from 'vue-class-component';
import TodoListItem from './TodoListItem';
import ProjectLogo from './ProjectLogo';
import store from '../stores/main';
import { decode } from '../htmlspecialchars';

const ProjectActiveTasksBoardProps = Vue.extend({
    props: {
        project: Object,
        tasks: Object,
        groups: Object
    }
})

@Component({
    components: { TodoListItem, ProjectLogo }
})
export default class ProjectActiveTasksBoard extends ProjectActiveTasksBoardProps {
    store = store;
    decode = decode;
}
</script>