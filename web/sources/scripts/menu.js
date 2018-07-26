;new Vue({
    el: "#menu",
    mounted: function() {
        var contents = this.$el.querySelectorAll(".menu-item__content");
        for (var i = 0; i < contents.length; ++i) {
            var content = contents[i];
            content.initialHeight = $(content).css('height');
            $(content).css('height', '0');
            $(content).css('display', 'none');
            var item = $(content).parent('.menu-item');
            item.removeClass('menu__item--opened');
            item.on('click', this.$options.methods.toggle);
        }
    },
    methods: {
        toggle: function(event) {
            if (!$(event.target).is('.menu-item__header') && !$(event.target).parent().is('.menu-item__header')) return;
            var item = $(event.target).closest('.menu-item')[0];
            var content = item.querySelector('.menu-item__content');
            if ($(item).hasClass('menu__item--opened')) {
                var completed = function () {
                    $(item).removeClass('menu__item--opened');
                    $(content).css('display', 'none');
                };
                $(content).animate({
                    'height': 0
                }, 200, '', completed);
            } else {
                $(content).css('display', '');
                $(item).addClass('menu__item--opened');
                $(content).animate({
                    'height': content.initialHeight
                }, 200);
            }
        }
    }
});