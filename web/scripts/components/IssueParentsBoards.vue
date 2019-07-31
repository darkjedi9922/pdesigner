<template>
    <div class="issue__parents" v-if="parents.length !== 0">
        <div 
            v-for="parent in parents"
            :key="parent.id"
            class="box"
        >
            <div class="issue">
                <div class="issue__title">
                    <todo-status-icon
                        :status="parent.status"
                        :selectable="false">
                    </todo-status-icon>
                    <a :href="parent.url" class="issue__parent"
                        >#{{ parent.number }} {{ decode(parent.title) }}</a>
                    <i class="icon angle down issue__parent-arrow"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
import TodoStatusIcon from './TodoStatusIcon';
import Component from 'vue-class-component';
import { decode } from '../htmlspecialchars';

const IssueParentsBoardsProps = Vue.extend({
    props: {
        parents: Array
    },
    components: { TodoStatusIcon }
});

@Component
export default class IssueParentsBoards extends IssueParentsBoardsProps {
    decode = decode;
}
</script>
