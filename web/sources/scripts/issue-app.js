;new Vue({
    el: '#issue-app',
    mounted: function() {
        var textElement = this.$el.querySelector('.issue__text');
        if (textElement) textElement.innerHTML = marked(textElement.innerText, { sanitize: false });
    }
});