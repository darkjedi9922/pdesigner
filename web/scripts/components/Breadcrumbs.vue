<template>
    <div class="breadcrumb">
        <span v-for="(item, index) in items">
            <a 
                :class="classNames('breadcrumb__section', {'breadcrumb__section--link': item.href})" 
                :href="item.href"
            >{{ item.name }}</a>
            <span v-if="index !== items.length - 1" class="breadcrumb__divisor">&nbsp;</span>
        </span>
    </div>
</template>

<script lang="ts">
import Vue from 'vue'
import classNames from 'classnames'
export default Vue.extend({
    props: {
        items: Array // of { name: string, href?: string }
    },
    data() {
        return {
            classNames
        }
    }
})
</script>

