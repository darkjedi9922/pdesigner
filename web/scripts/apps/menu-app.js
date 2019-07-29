import Vue from 'vue';
import $ from 'jquery';
import ProjectLogo from '../components/ProjectLogo';

new Vue({
    el: "#menu",
    components: { ProjectLogo },
    data: {
        contentVisibleWidth: null
    },
    mounted: function() {
        let content = $(this.$el).find('#menu-content').first();
        let toggleButton = $(this.$el).find('#menu-toggle').first();
        toggleButton.on('click', () => {
            if (content.width()) {
                this.contentVisibleWidth = content.width();
                content.animate({ width: 0 }, 200, () => {
                    toggleButton.addClass('menu__special--open-rotate');
                    toggleButton.removeClass('menu__special--close-rotate');
                });
            } else {
                content.animate({ width: this.contentVisibleWidth }, 200, () => {
                    toggleButton.addClass('menu__special--close-rotate');
                    toggleButton.removeClass('menu__special--open-rotate');
                });
            }
        });
    }
});