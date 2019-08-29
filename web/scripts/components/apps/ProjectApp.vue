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
        <delete-confirm-modal
            ref="projectDeleteConfirmationModal"
            title="Удалить проект"
            desc="Все содержимое проекта будет удалено. Вы уверены, что хотите 
                удалить проект без возможности восстановления?"
            @approved="deleteProject"
        ></delete-confirm-modal>
        </div>
    </div>
</template>

<script lang="ts">
import TodoApp from './TodoApp'; 
import DeleteConfirmModal from '../DeleteConfirmModal';
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
    components: { TodoApp, DeleteConfirmModal },
    methods: {
        decode,
        showDeleteProjectConfirm() {
            this.$refs.projectDeleteConfirmationModal.show();
        },
        deleteProject() {
            document.location.href = this.urlDeleteProject;
        }
    }
}
</script>