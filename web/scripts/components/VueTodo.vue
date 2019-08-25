<template>
    <div>
        <div 
            v-for="(group, id) in listedGroups"
            :key="id"
            class="todo"
        >
            <todo-group
                :data="group"
                @removed="removeGroup(id)"
            ></todo-group>
            <todo-list
                :mode="mode"
                :list="group.list"
                @status-applied="applyStatus($event.itemId, $event.status)"
                @item-removed="removeItem($event.id)"
            ></todo-list>
        </div>
    </div>
</template>

<script lang="ts">
import TodoGroup from './TodoGroup';
import TodoList from './TodoList';

export default {
    components: { TodoGroup, TodoList },
    props: {
        listedGroups: {
            required: true,
            type: Object,
            default: function() { return {} }
        },
        mode: {
            type: String,
            required: false,
            default: 'all'
        }
    },
    methods: {
        applyStatus: function(itemId: number, status: number) {
            this.$emit('status-applied', { itemId, status });
        },
        removeItem: function(id: number) {
            this.$emit('item-removed', { id });
        },
        removeGroup: function(id: number) {
            this.$emit('group-removed', { id });
        }
    }
};
</script>