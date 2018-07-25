/*new Vue({
    el: '#vue-hello',
    data: {
        hidden: false,
        startLeft: parseInt($('#app > span').css('left')),
        startMarginRight: parseInt($('#app > span').css('margin-right')),
        startMarginLeft: parseInt($('#app > span').css('margin-left'))
    },
    methods: {
        toggleSpan: function() {
            var span = $('#app > span');
            var width = parseInt(span.css('width')) + this.startMarginLeft + this.startMarginRight;
            var diff = this.hidden ? 0 : -width;
            var newLeft = this.startLeft + diff;
            var newMarginRight = this.startMarginRight + diff;
            this.hidden = !this.hidden;
            span.animate({
                "left": newLeft,
                "margin-right": newMarginRight
            }, 500);
        }
    }
});*/