import mainStore from '../stores/main';
import $ from 'jquery';
import Vue from 'vue';
import Component from 'vue-class-component';

@Component
export default class TaskMixin extends Vue {
    store = mainStore;

    setTaskStatus(id: number, status: number, token: string): void {
        $.ajax({
            url: this.store.tasks.links.getToggle(),
            method: 'POST',
            data: 'id=' + id
                + '&status=' + +status
                + '&_csrf=' + token
            // TODO: красиво выводить красивую ошибку при ошибке
        });
    }
}