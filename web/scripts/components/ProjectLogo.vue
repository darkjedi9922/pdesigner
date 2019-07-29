<template>
    <div :class="['project-logo project-logo--' + color]">{{ name[0] }}</div>
</template>

<script lang="ts">
import Vue from 'vue';
import Component from 'vue-class-component';

const ProjectLogoProps = Vue.extend({
    props: {
        name: String
    }
});

const COLORS: Array<string> = ['red', 'green', 'blue', 'purple', 'yellow']

@Component
export default class ProjectLogo extends ProjectLogoProps {
    get color(): string {
        return COLORS[this.name.charCodeAt(0) % COLORS.length];
    }
}
</script>