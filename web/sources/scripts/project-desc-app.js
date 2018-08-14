;new Vue({
    el: '#project-desc-app',
    mixins: [markMixin],
    mounted: function() {
        this.markdown('.project__desc');
    }
});