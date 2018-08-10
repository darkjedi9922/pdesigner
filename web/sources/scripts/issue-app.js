;new Vue({
    el: '#issue-app',
    mixins: [taskMixin],
    data: function() {
        return {
            id: 0,
            checked: false,
            token: ''
        }
    },
    mounted: function() {
        var textElement = this.$el.querySelector('.issue__text');
        if (textElement) textElement.innerHTML = marked(textElement.innerText, { sanitize: false });
    },
    methods: {
        switchChecked: function() {
            this.checked = !this.checked;
            this.setTaskChecked(this.id, this.checked, this.token);
        }
    }
});