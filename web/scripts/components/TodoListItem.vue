<template>
    <div :class="['todo-item', {
        'todo-item--checked': statusChecked
    }]">
        <div class="todo-item__container">
            <contextmenu class="todo-contextmenu">
                <a :href="store.tasks.links.getAddSubtask(id)" class="todo-contextmenu__item">
                    <i class="icon add"></i>Добавить позадачу
                </a>
                <a :href="store.tasks.links.getEdit(id)" class="todo-contextmenu__item">
                    <i class="icon edit"></i>Редактировать
                </a>
                <a @click="remove" class="todo-contextmenu__item"><i class="icon trash"></i>Удалить</a>
            </contextmenu>
            <todo-status-icon 
                :status="theStatus"
                :selectable="true"
                :id="'checkbox-' + id">
                <contextmenu class="todo-contextmenu" on="click" :for="'checkbox-' + id">
                    <a 
                        v-for="issueStatus in IssueStatus"
                        :key="issueStatus.id"
                        class="todo-contextmenu__item" @click="setStatus(issueStatus.id)">
                        <i :class="'icon ' + issueStatus.menu.icon"></i>{{ issueStatus.name }}
                    </a>
                </contextmenu>
            </todo-status-icon>
            <a 
                :href="store.tasks.links.getPage(id)" 
                class="todo-item__label"
                :class="{ 'todo-item__label--checked': statusChecked }"
            >#{{ number }} {{ title }}</a>
        </div>
        <slot name="sublist"></slot>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import mainStore from '../stores/main';
import TodoStatusIcon from './TodoStatusIcon';
import Component from 'vue-class-component';
import Contextmenu from './contextmenu';
import { IssueStatus, findStatusById } from '../models';

const TodoListProps = Vue.extend({
    props: {
        id: Number,
        number: Number,
        title: String,
        parentId: Number,
        groupId: Number,
        status: Number
    },
})

@Component({
    components: { TodoStatusIcon, Contextmenu },
    computed: {
        statusChecked: function() {
            return IssueStatus[findStatusById(this.theStatus)].checked;
        }
    }
})
export default class TodoListItem extends TodoListProps {
    store = mainStore;
    theStatus: number = this.status;
    
    IssueStatus = IssueStatus;

    setStatus(status: number): void {
        this.theStatus = status;
        this.$nextTick(function() {
            this.$emit('status-changed', {
                status: status
            });
        });
    }

    remove(): void {
        this.$emit('removed');
    }
};
</script>