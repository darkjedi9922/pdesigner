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
                    <span class="subboard__count">{{ tasks.length }}</span>
                </div>
                <span class="project-atb__desc">{{ simpleDescription }}</span>
            </div>
        </div>
        <div class="subboard__content">
            <todo-list-item
                v-for="task in tasks"
                :key="task.id"
                :number="task.number"
                :title="task.title"
                :parentId="0"
                :groupId="0"
                :status="task.status"
            ></todo-list-item>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
import Component from 'vue-class-component';
import TodoListItem from './TodoListItem';
import ProjectLogo from './ProjectLogo';
import { mark } from '../mixins/mark';

const ProjectActiveTasksBoardProps = Vue.extend({
    props: {
        name: String,
        description: String,
        tasks: Array
    }
})

@Component({
    components: { TodoListItem, ProjectLogo }
})
export default class ProjectActiveTasksBoard extends ProjectActiveTasksBoardProps {
    get simpleDescription(): string {
        let tempElem = document.createElement('span');
        tempElem.innerHTML = mark(this.description);
        // innerText возвращает содержимое в виде чистого неформатированого текста.
        return tempElem.innerText;
    }
}
</script>
