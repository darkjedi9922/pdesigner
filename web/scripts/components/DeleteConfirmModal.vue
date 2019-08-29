<template>
    <div class="ui basic mini modal" ref="projectDeleteConfirmationModal">
        <h2 class="ui icon header">
            <i class="trash icon"></i>
            <div class="content">{{ title }}</div>
        </h2>
        <div class="content"><p>{{ desc }}</p></div>
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
</template>

<script lang="ts">
import $ from 'jquery';

export default {
    props: {
        title: {
            type: String,
            required: true
        },
        desc: {
            type: String,
            required: true
        }
    },
    methods: {
        show() {
            ($(this.$refs.projectDeleteConfirmationModal) as any)
                .modal({
                    onApprove: () => this.$emit('approved')
                })
                .modal('show');
        }
    }
}
</script>
