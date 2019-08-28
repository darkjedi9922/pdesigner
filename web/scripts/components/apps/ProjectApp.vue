<template>
    <div class="boxes">
        <div class="boxes__item boxes__item--main">
            <div v-if="description" class="box" id="project-desc-app">
                <span class="project__desc">{{ decode(description) }}</span>
            </div>
            <todo-app
                :projectId="projectId"
                :list="list"
                :mode="mode"
                :groups="groups"
                :token="token"
            ></todo-app>
        </div>
        <div class="boxes__item">
            <div class="box">
                <div class="task-toolbar task-toolbar--vertical">
                    <a :href="urlEditProject" class="task-toolbar__button">Редактировать проект</a>
                    <a @click="showDeleteProjectConfirm" class="task-toolbar__button task-toolbar__button--bad">Удалить проект</a>
                </div>
            </div>
        </div>
        <div class="ui basic mini modal" ref="projectDeleteConfirmationModal">
            <h2 class="ui icon header">
                <i class="trash icon"></i>
                <div class="content">Удалить проект</div>
            </h2>
            <div class="content">
                <p>
                    Все содержимое проекта будет удалено.
                    Вы уверены что хотите удалить проект без возможности восстановления?
                </p>
            </div>
            <div class="actions">
                <div class="ui basic cancel inverted button">
                    <i class="cancel icon"></i>
                    Отмена
                </div>
                <div class="ui red approve inverted button">
                    <i class="trash icon"></i>
                    Удалить
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import TodoApp from './TodoApp'; 
import { decode } from '../../htmlspecialchars';
import $ from 'jquery';

export default {
    props: {
        projectId: Number,
        description: String,
        list: Array,
        groups: Object,
        urlEditProject: String,
        urlDeleteProject: String,
        mode: String,
        token: String
    },
    components: { TodoApp },
    methods: {
        decode,
        showDeleteProjectConfirm() {
            ($(this.$refs.projectDeleteConfirmationModal) as any)
                .modal({
                    onApprove: () => document.location.href = this.urlDeleteProject
                })
                .modal('show');
        }
    }
}
</script>