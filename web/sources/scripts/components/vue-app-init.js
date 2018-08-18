;Vue.component('vue-app-init', {
    mounted: function() {
        this.$emit('before-mount');
    },
    template: '<div></div>'
});