;Vue.component('contextmenu', {
    data: function() {
        return {
            parent: null,
            exists: false,
            checked: false,
            x: 0,
            y: 0
        }
    },
    mounted: function() {
        this.parent = $(this.$el).parent()[0];

        $(document.body).on('contextmenu', (function (event) {
            if (event.target === this.parent) {
                this.exists = true;
                this.x = event.clientX + pageXOffset + 1;
                this.y = event.clientY + pageYOffset;
                this.$nextTick(this.checkPosition);
                event.preventDefault();
            } else this.exists = false;
        }).bind(this));

        $(document.body).on('click', (function() {
            this.exists = false;
            this.checked = false;
        }).bind(this));
    },
    methods: {
        checkPosition: function() {
            var height = "".split.call($(this.$el).css('height'), 'px')[0];
            if ((+this.y - +pageYOffset + +height) > window.innerHeight) this.y -= height;
            var width = "".split.call($(this.$el).css('width'), 'px')[0];
            if ((+this.x - +pageXOffset + +width) > window.innerWidth) this.x -= width;
            this.$nextTick(function () {
                this.checked = true;
            });
        }
    },
    template: '\
        <div v-if="exists" :style="{ \
            left: x + \'px\',\
            top: y + \'px\',\
            visibility: (checked ? \'visible\' : \'hidden\'),\
            position: \'absolute\' }">\
        <slot></slot></div>'
});