var htmlspecial = require('./../htmlspecialchars');
var YiiForm = require('./yii-form');
var previewMixin = require('./preview');
    
module.exports = {
    extends: YiiForm,
    mixins: [previewMixin],
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
        decodedText: function () {
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
        this.updateTextPreview();
    },
    methods: {
        updateTextPreview() {
            this.updatePreview(this.$refs.textInput, this.$refs.preview);
        }
    }
}