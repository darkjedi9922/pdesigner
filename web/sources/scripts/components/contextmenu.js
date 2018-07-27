;Vue.component('contextmenu', {
    data: function() {
        return {
            parent: null,
            exists: false,
            x: 0,
            y: 0
        }
    },
    mounted: function() {
        this.parent = $(this.$el).parent()[0];

        $(document.body).on('contextmenu', (function (event) {
            if (event.target === this.parent) {
                this.exists = true;
                this.x = event.clientX;
                this.y = event.clientY;
                event.preventDefault();
            } else this.exists = false;
        }).bind(this));

        $(document.body).on('click', (function() {
            this.exists = false;
        }).bind(this));
    },
    template: '<div v-if="exists" :style="{ left: x + \'px\', top: y + \'px\', position: \'absolute\' }"><slot></slot></div>'
});