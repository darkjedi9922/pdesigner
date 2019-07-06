<template>
    <div 
        :class="['todo-icon', colorClass, {
            'todo-icon--selectable': selectable,
            'todo-icon--checked': statusDetails.checked,
        }]">
        <div class="todo-icon__box"><i :class="'icon ' + statusDetails.icon.name"></i></div>
        <slot></slot>
    </div>
</template>

<script lang="ts">
import { IssueStatus, findStatusById } from '../models';

export default {
    props: {
        status: Number,
        selectable: Boolean
    },
    computed: {
        statusDetails: function() {
            return IssueStatus[findStatusById(this.status as unknown as number)];
        },
        colorClass: function() {
            return 'todo-icon--' + this.statusDetails.icon.color;
        }
    },
    mounted: function() {
        this.$emit('load');
    }
};
</script>