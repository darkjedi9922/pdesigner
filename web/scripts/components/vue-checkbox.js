export default {
    props: {
        checked: Boolean
    },
    mounted: function() {
        this.$emit('load');
    },
    template: '\
        <div :class="{ \'_checked_\': checked }">\
            <div class="_box_"><i class="check icon"></i></div>\
            <slot></slot>\
        </div>\
    '
};