var YiiForm = require('./yii-form');
var previewMixin = require('./preview');
var htmlspecial = require('./../htmlspecialchars');

module.exports = {
    extends: YiiForm,
    mixins: [previewMixin],
    props: {
        name: {
            type: String,
            default: ''
        },
        description: {
            type: String,
            default: ''
        }
    },
    computed: {
        decodedDescription: function () {
            // Из PHP передаются закодированные html спецсимволы, и чтобы textarea
            // понимал их так как они были перед кодировкой (как их ввел юзер), нужно
            // декодировать их обратно.
            return htmlspecial.decode(this.description);

            // О безопасности не стоит волноваться, marked потом обрабатывает это все
            // и все "небезопасные" скрипты будут вставлены динамически, а так
            // они не выполняются.
        }
    },
    mounted() {
        this.updateDescriptionPreview();
    },
    methods: {
        updateDescriptionPreview: function () {
            this.updatePreview(this.$refs.descriptionInput, this.$refs.preview);
        }
    }
};