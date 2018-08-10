;new Vue({
    el: '#issue-app',
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
            console.log('switch');
            this.checked = !this.checked;
            $.ajax({
                url: '/web/index.php?r=todo/toggle',
                method: 'POST',
                data: 'id=' + this.id
                    + '&checked=' + +this.checked
                    + '&_csrf=' + this.token
            });
        }
    }
});