<template>
    <div class="subboard project-atb">
        <div class="subboard__header project-atb__header">
            <project-logo 
                class="project-atb__logo"
                :name="name"
            ></project-logo>
            <div class="project-atb__intro">
                <div class="project-atb__title">
                    <span class="subboard__title">{{ name }}</span>
                    <span class="subboard__count">{{ Object.keys(tasks).length }}</span>
                </div>
                <span class="project-atb__desc">{{ simpleDescription }}</span>
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
                    ># {{ task.number }} {{ task.title }}</a>
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
import { mark } from '../mixins/mark';
import store from '../stores/main';

const ProjectActiveTasksBoardProps = Vue.extend({
    props: {
        name: String,
        description: String,
        tasks: Object,
        groups: Object
    }
})

@Component({
    components: { TodoListItem, ProjectLogo }
})
export default class ProjectActiveTasksBoard extends ProjectActiveTasksBoardProps {
    store = store;

    get simpleDescription(): string {
        let tempElem = document.createElement('span');
        tempElem.innerHTML = mark(this.description);
        // innerText возвращает содержимое в виде чистого неформатированого текста.
        return tempElem.innerText;
    }
}
</script>
