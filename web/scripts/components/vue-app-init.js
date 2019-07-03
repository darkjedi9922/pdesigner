export default {
    mounted: function() {
        this.$emit('before-mount');
    },
    template: '<div></div>'
};