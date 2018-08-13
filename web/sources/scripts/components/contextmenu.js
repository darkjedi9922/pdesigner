/**
 * Появляется при событии "contextmenu" родительского элемента.
 * Замечание: если вкладывать контекстные меню друг в друга, дочерние работать не будут.
 * Для этого нужно делать их полностью независимыми и связывать их через параметр for.
 */
;Vue.component('contextmenu', {
    props: {
        /**
         * Id элемента к которому привязан компонент.
         * Если он не указан, используетяс родительский элемент.
         */
        for: {
            type: String,
            default: null
        },
        /**
         * Событие, которое будет вызывать контекстное меню.
         */
        on: {
            type: String,
            default: 'contextmenu'
        }  
    },
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
        //$(document.body).on('contextmenu', this.hide.bind(this));
        //$(document.body).on('click', this.hide.bind(this));

        this.parent = $(this.$el).parent()[0];
        $(document.body).on(this.on, (function (event) {
            if ((this.for === null && event.target === this.parent) || (this.for !== null && $(event.target).closest('#' + this.for).length !== 0)) {
                this.exists = true;
                this.x = event.clientX + pageXOffset + 1;
                this.y = event.clientY + pageYOffset;
                this.$nextTick(this.checkPosition);
                event.preventDefault();
                setTimeout((function() {
                    $(document.body).on('contextmenu', this.hide);
                    $(document.body).on('click', this.hide);
                }).bind(this), 200);
            }
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
        },
        hide: function() {
            this.exists = false;
            this.checked = false;
            $(document.body).off('contextmenu', this.hide);
            $(document.body).off('click', this.hide);
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