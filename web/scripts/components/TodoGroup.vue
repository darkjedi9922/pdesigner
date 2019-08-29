<template>
    <div :class="[mainClass, colorClass]">
            <span 
                class="todo-group__title" 
                @keydown.enter="titleEnterDown" 
                @blur="titleEnterDown"
                spellcheck="false"
            >{{ data.name }}<contextmenu class="todo-contextmenu">
                    <span class="todo-contextmenu__item todo-group__color-menu" id="change-color"><i class="icon paint brush"></i>Изменить цвет
                        <table class="todo-contextmenu todo-contextmenu--submenu todo-group__color-table" @click="colorClicked">
                            <tr>
                                <td class="todo-group__color-cell todo-group--bckg-1"></td>
                                <td class="todo-group__color-cell todo-group--bckg-2"></td>
                            </tr>
                            <tr>
                                <td class="todo-group__color-cell todo-group--bckg-3"></td>
                                <td class="todo-group__color-cell todo-group--bckg-4"></td>
                            </tr>
                        </table>
                    </span>
                    <span class="todo-contextmenu__item" @click="startEditingTitle"><i class="icon pencil alternate"></i>Изменить название</span>
                    <a :href="store.groups.links.getAddTask(data.id)" class="todo-contextmenu__item"><i class="icon add"></i>Добавить задачу</a>
                    <span class="todo-contextmenu__item" @click="$refs.deleteGroupConfirm.show()"><i class="icon trash"></i>Удалить группу</span>
                </contextmenu>
            </span>
            <delete-confirm-modal
                ref="deleteGroupConfirm"
                title="Удалить группу задач"
                desc="Все содержимое группы будет удалено. Вы уверены, что хотите
                    удалить группу без возможности восстановления?"
                @approved="deleteGroup"
            ></delete-confirm-modal>
        </div>
</template>

<script lang="ts">
import Vue from 'vue'
import mainStore from '../stores/main';
import Contextmenu from './contextmenu';
import DeleteConfirmModal from './DeleteConfirmModal';
import $ from 'jquery';

export default {
    props: {
        data: Object
    },
    components: { Contextmenu, DeleteConfirmModal },
    data: function() {
        return {
            store: mainStore,
            colorId: undefined,
            mainClass: 'todo-group'
        }
    },
    computed: {
        colorClass: function() {
            return 'todo-group--color-' + this.colorId;
        },
        titleElem: function() {
            return this.$el.querySelector('.todo-group__title');
        }
    },
    mounted: function() {
        this.colorId = this.data.colorId; // свойства Vue.props изменять "нельзя", поэтому используем Vue.data
        if (this.data.isNew) // Устанавливается при добавлении новой группы
            this.startEditingTitle();
    },
    methods: {
        colorClicked: function(event) {
            for (var i = 1; i <= 4; ++i) {
                if ($(event.target).hasClass('todo-group--bckg-' + i)) {
                    this.colorId = i;
                    this.setDbColorId(i);
                }
            }
        },
        setDbColorId: function(id) {
            $.ajax({ url: mainStore.groups.links.setColorId(this.data.id, id) });
        },
        setDbName: function(name) {
            $.ajax({ url: mainStore.groups.links.setName(this.data.id, name) });
        },
        startEditingTitle: function() {
            this.titleElem.contentEditable = true;
            this.setCaret(this.titleElem);
        },
        endEditingTitle: function() {
            if (this.titleElem.textContent.length === 0) this.titleElem.focus();
            else {
                this.titleElem.contentEditable = false;
                this.titleElem.blur();
                this.setDbName(this.titleElem.textContent);
            }
        },
        titleEnterDown: function(event) {
            if (this.titleElem.contentEditable === 'true') {
                event.preventDefault();
                this.endEditingTitle();
            }
        },
        setCaret(elem) {
            elem.focus();
        },
        deleteGroup() {
            this.$emit('removed');
        }
    }
}
</script>