var marked = require('marked');
var debounce = require('lodash.debounce');
var htmlspecial = require('./../../htmlspecialchars');
var YiiForm = require('./yii-form');
    
module.exports = {
    extends: YiiForm,
    props: {
        title: {
            type: String,
            default: ''
        },
        text: {
            type: String,
            default: ''
        }
    },
    computed: {
        undecodedText: function () {
            // Из PHP передаются закодированные html спецсимволы, и чтобы textarea
            // понимал их так как они были перед кодировкой (как их ввел юзер), нужно
            // декодировать их обратно.
            return htmlspecial.decode(this.text);

            // О безопасности не стоит волноваться, marked потом обрабатывает это все
            // и все "небезопасные" скрипты будут вставлены динамически, а так
            // они не выполняются.
        }
    },
    mounted() {
        this.updatePreview();
    },
    methods: {
        updatePreview: debounce((function () {
            var text = this.$refs.textInput.value;
            this.$refs.preview.innerHTML = marked(text, {
                sanitize: false
            });
        }), 200)
    }
}