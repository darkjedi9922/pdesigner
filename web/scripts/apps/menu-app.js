import Vue from 'vue';
import $ from 'jquery';
import ProjectLogo from '../components/ProjectLogo';

new Vue({
    el: "#menu",
    components: { ProjectLogo },
    data: {
        closed: false,
        contentVisibleWidth: null
    },
    computed: {
        content: function() {
            return $(this.$el).find('#menu-content').first();
        },
        toggleButton: function() {
            return $(this.$el).find('#menu-toggle').first();
        }
    },
    mounted: function() {
        if (this.getCookie('dashboard-menu') === '0') this.startupClose();
        this.toggleButton.on('click', () => {
            if (this.content.width()) this.close();
            else this.open();
        });
    },
    methods: {
        close() {
            this.contentVisibleWidth = this.content.width();
            this.content.animate({ width: 0 }, 200, () => {
                this.toggleButton.addClass('menu__special--open-rotate');
                this.toggleButton.removeClass('menu__special--close-rotate');
                this.closed = true;
                this.saveState();
            });
        },
        open() {
            this.content.animate({ width: this.contentVisibleWidth }, 200, () => {
                this.toggleButton.addClass('menu__special--close-rotate');
                this.toggleButton.removeClass('menu__special--open-rotate');
                this.closed = false;
                this.saveState();
            });
        },
        getCookie(name) {
            var matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
            return matches ? decodeURIComponent(matches[1]) : null;
        },
        startupClose() {
            this.contentVisibleWidth = this.content.width();
            this.content.width(0);
            this.toggleButton.addClass('menu__special--startup-close-rotate');
            this.closed = true;
        },
        saveState() {
            // Срок истечения +1 год от текущего момента
            let date = new Date;
            date.setDate(date.getDate() + 365);
            let expires = date.toUTCString();

            let value = (this.closed ? '0' : '1');            
            document.cookie = 'dashboard-menu=' + value + 
                ';path=/;expires=' + expires; 
        }
    }
});