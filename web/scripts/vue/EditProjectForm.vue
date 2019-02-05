<template>
    <form method="post">
        <input type="hidden" name="_csrf" :value="csrfToken">
        <div class="form">
            <div class="form__content">
                <div class="form__field">
                    <span class="form__label">Название:</span>
                    <div class="form__input-container">
                        <input type="text" class="form__input" :name="yiiModel + '[name]'" spellcheck="false" :value="name">
                    </div>
                </div>
                <div class="form__field">
                    <span class="form__label">Описание:</span>
                    <div class="form__input-container">
                        <textarea 
                            class="form__textarea" 
                            :name="yiiModel + '[description]'" 
                            rows="10" 
                            spellcheck="false"
                            ref="descriptionInput"
                            @keyup="updatePreview"
                        >{{ undecodedDescription }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div ref="preview" class="form__preview"></div>
        <button class="form__button">Сохранить</button>
    </form>
</template>

<script>
var YiiForm = require('./mixins/yii-form');
var marked = require('marked');
var debounce = require('lodash.debounce');
var htmlspecial = require('./../htmlspecialchars');

module.exports = {
    extends: YiiForm,
    props: {
        name: {
            type: String,
            required: true
        },
        description: {
            type: String,
            default: ''
        }
    },
    computed: {
        undecodedDescription: function () {
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
        this.updatePreview();
    },
    methods: {
        updatePreview: debounce((function () {
            var text = this.$refs.descriptionInput.value;
            this.$refs.preview.innerHTML = marked(text, {
                sanitize: false
            });
        }), 200)
    }
}
</script>