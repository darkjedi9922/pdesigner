;Vue.component('vue-checkbox', {
    props: {
        checked: Boolean
    },
    data: function() {
        return {
            isChecked: this.checked
        }
    },
    methods: {
        toggle: function() {
            this.isChecked = !this.isChecked;
            this.$emit('toggle');
        }  
    },
    template: '\
        <div :class="{ \'_checked_\': isChecked }">\
            <div class="_box_" v-on:click="toggle"><i class="check icon"></i></div>\
            <span class="_label_"><slot></slot></span>\
        </div>\
    '
});