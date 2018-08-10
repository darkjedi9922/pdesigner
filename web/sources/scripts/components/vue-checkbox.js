; Vue.component('vue-checkbox', {
    props: {
        checked: Boolean
    },
    mounted: function() {
        this.$emit('load');
    },
    methods: {
        toggle: function () {
            this.checked = !this.checked;
            this.$emit('toggle');
        }
    },
    template: '\
        <div :class="{ \'_checked_\': checked }">\
            <div class="_box_" v-on:click="toggle"><i class="check icon"></i></div>\
            <span class="_label_"><slot></slot></span>\
        </div>\
    '
});