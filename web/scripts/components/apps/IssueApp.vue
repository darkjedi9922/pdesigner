<template>
    <div class="boxes">
        <div class="boxes__item boxes__item--main">
            <issue-parents-boards :parents="parents"></issue-parents-boards>
            <div class="box">
                <div class="issue">
                    <div class="issue__title">
                        <todo-status-icon
                            :status="theStatus"
                            :selectable="false">
                        </todo-status-icon>
                        <span>#{{ number }} {{ decode(title) }}</span>
                    </div>
                    <span class="issue__text" v-if="text">{{ decode(text) }}</span>
                </div>
            </div>
            <breadcrumbs v-if="hasChildren" :items="[{ name: 'Подзадачи'}]"></breadcrumbs>
            <div v-if="hasChildren" class="box">
                <todo-list 
                    :list="children"
                    :parentItemId="id"
                ></todo-list>
            </div>
        </div>
        <div class="boxes__item">
            <div class="box">
                <div class="task-toolbar task-toolbar--vertical">
                    <a :href="addItemUrl" class="task-toolbar__button task-toolbar__button--good">Добавить подзадачу</a>
                    <a :href="editItemUrl" class="task-toolbar__button">Редактировать</a>
                    <a @click="$refs.deleteConfirm.show()" class="task-toolbar__button task-toolbar__button--bad">Удалить</a>
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
        <delete-confirm-modal
            ref="deleteConfirm"
            title="Удалить задачу"
            desc="Все подзадачи также будут удалены. Вы уверены, что хотите удалить
                задачу без возможности восстановления?"
            @approved="remove"
        ></delete-confirm-modal>
    </div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component, { mixins } from 'vue-class-component';
import taskMixin from '../../mixins/task';
import markMixin from '../../mixins/mark';
import TodoStatusIcon from '../TodoStatusIcon';
import IssueParentsBoards from '../IssueParentsBoards';
import DeleteConfirmModal from '../DeleteConfirmModal';
import { IssueStatus } from '../../models';
import { decode } from '../../htmlspecialchars';
import TodoList from '../TodoList';
import Breadcrumbs from '../Breadcrumbs';
import $ from 'jquery';

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
        deleteItemUrl: String,
        parents: Array
    }
});

@Component({
    components: {
        TodoStatusIcon,
        IssueParentsBoards,
        DeleteConfirmModal,
        TodoList,
        Breadcrumbs
    }
})
export default class IssueApp extends mixins(IssueAppProps, taskMixin, markMixin) {
    theStatus: number = this.status;
    children = [];
    IssueStatus = IssueStatus;
    decode = decode;

    get hasChildren(): boolean {
        return this.children.length !== 0; 
    }

    mounted(): void {
        this.markdown('.issue__text');
        $.ajax({
            url: '/todo/children',
            method: 'get',
            data: { id: this.id },
            dataType: 'json',
            success: (result) => this.children = result
        })
    }

    remove(): void {
        document.location.href = this.deleteItemUrl;
    }
} 
</script>