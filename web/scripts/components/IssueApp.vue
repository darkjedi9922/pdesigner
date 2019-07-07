<template>
    <div class="boxes">
        <div class="boxes__item boxes__item--main">
            <div class="box">
                <div class="issue" id="issue-app">
                    <div class="issue__title">
                        <todo-status-icon
                            :status="theStatus"
                            :selectable="false">
                        </todo-status-icon>
                        <span>#{{ number }} {{ title }}</span>
                    </div>
                    <span class="issue__text" v-if="decodedText">{{ decodedText }}</span>
                </div>
            </div>
        </div>
        <div class="boxes__item">
            <div class="box">
                <div class="task-toolbar task-toolbar--vertical">
                    <a :href="addItemUrl" class="task-toolbar__button task-toolbar__button--good">Добавить подзадачу</a>
                    <a :href="editItemUrl" class="task-toolbar__button">Редактировать</a>
                    <a :href="deleteItemUrl" class="task-toolbar__button task-toolbar__button--bad">Удалить</a>
                </div>
            </div>
            <div class="box">
                <div class="task-status-toolbar">
                    <span
                        :class="['task-status__item', {
                            'task-status__item--selected': issueStatus.id == theStatus 
                        }]"
                        v-for="issueStatus in IssueStatus"
                        :key="issueStatus.id"
                        @click="
                            theStatus = issueStatus.id;
                            setTaskStatus(id, issueStatus.id, token);
                        "
                    >{{ issueStatus.name }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component, { mixins } from 'vue-class-component';
import taskMixin from '../mixins/task';
import markMixin from '../mixins/mark';
import TodoStatusIcon from './TodoStatusIcon';
import { IssueStatus } from '../models';
import { decode } from '../htmlspecialchars';

const IssueAppProps = Vue.extend({
    props: {
        id: Number,
        status: Number,
        token: String,
        number: Number,
        title: String,
        text: String,
        addItemUrl: String,
        editItemUrl: String,
        deleteItemUrl: String
    }
});

@Component({
    components: { TodoStatusIcon }
})
export default class IssueApp extends mixins(IssueAppProps, taskMixin, markMixin) {
    theStatus: number = this.status;
    decodedText: string = decode(this.text);
    IssueStatus = IssueStatus;

    mounted(): void {
        this.markdown('.issue__text');
    }
} 
</script>