<template>
    <div class="issue__parents">
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
                        >#{{ parent.number }} {{ parent.title }}</a>
                    <i class="icon angle down issue__parent-arrow"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
import TodoStatusIcon from './TodoStatusIcon';

export default Vue.extend({
    props: {
        parents: Array
    },
    components: { TodoStatusIcon }
})
</script>
