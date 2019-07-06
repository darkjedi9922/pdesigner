<template>
    <div class="todo-item" :class="{ 'todo-item--checked': theStatus }">
        <div class="todo-item__container">
            <contextmenu class="todo-contextmenu">
                <a :href="store.tasks.links.getAddSubtask(id)" class="todo-contextmenu__item">
                    <i class="icon add"></i>Добавить позадачу
                </a>
                <a :href="store.tasks.links.getEdit(id)" class="todo-contextmenu__item">
                    <i class="icon edit"></i>Редактировать
                </a>
                <a @click="$root.deleteItem(id)" class="todo-contextmenu__item"><i class="icon trash"></i>Удалить</a>
            </contextmenu>
            <vue-checkbox 
                class="todo-item__checkbox todo-item__checkbox--selectable" 
                :checked="Boolean(theStatus)" 
                :id="'checkbox-' + id">
                <contextmenu class="todo-contextmenu" on="click" :for="'checkbox-' + id">
                    <a class="todo-contextmenu__item" @click="setStatus(IssueStatus.UNDONE.id)">
                        <i class="icon calendar outline"></i>Невыполнено
                    </a>
                    <a class="todo-contextmenu__item" @click="setStatus(IssueStatus.DONE.id)">
                        <i class="icon calendar check outline"></i>Выполнено
                    </a>
                </contextmenu>
            </vue-checkbox>
            <a 
                :href="store.tasks.links.getPage(id)" 
                class="todo-item__label"
                :class="{ 'todo-item__label--checked': theStatus }"
            >#{{ number }} {{ title }}</a>
        </div>
        <slot name="sublist"></slot>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import mainStore from '../stores/main';
import VueCheckbox from './vue-checkbox';
import Component from 'vue-class-component';
import { IssueStatus } from '../models';

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
    components: { VueCheckbox }
})
export default class TodoListItem extends TodoListProps {
    store = mainStore;
    theStatus: number = this.status;
    
    $root: any;
    IssueStatus = IssueStatus;

    setStatus(status: number): void {
        this.theStatus = status;
        this.$nextTick(function() {
            this.$emit('status-changed', {
                status: status
            });
        });
    }
};
</script>