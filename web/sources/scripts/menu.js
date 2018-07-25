;new Vue({
    el: "#menu",
    mounted: function() {
        var contents = this.$el.querySelectorAll(".content");
        for (var i = 0; i < contents.length; ++i) {
            var content = contents[i];
            content.initialHeight = $(content).css('height');
            $(content).css('height', '0');
            $(content).css('display', 'none');
            var item = $(content).parent('.item');
            item.removeClass('opened');
            item.on('click', this.$options.methods.toggle);
        }
    },
    methods: {
        toggle: function(event) {
            if (!$(event.target).is('.header') && !$(event.target).parent().is('.header')) return;
            var item = $(event.target).closest('div.item')[0];
            var content = item.querySelector('.content');
            if ($(item).hasClass('opened')) {
                var completed = function () {
                    $(item).removeClass('opened');
                    $(content).css('display', 'none');
                };
                $(content).animate({
                    'height': 0
                }, 200, '', completed);
            } else {
                $(content).css('display', '');
                $(item).addClass('opened');
                $(content).animate({
                    'height': content.initialHeight
                }, 200);
            }
        }
    }
});