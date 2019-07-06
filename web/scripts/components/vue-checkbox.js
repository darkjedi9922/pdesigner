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
            <span class="_label_"><slot></slot></span>\
        </div>\
    '
};