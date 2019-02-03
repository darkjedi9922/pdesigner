<template>
    <form method="post" class="form">
        <div class="form__content">
            <input type="hidden" name="_csrf" :value="csrfToken">
            <div class="form__field">
                <span class="form__label">Название:</span>
                <div class="form__input-container">
                    <input class="form__input" type="text" :name="yiiModel + '[title]'" :value='title' spellcheck="false">
                </div>
            </div>
            <div class="form__field">
                <span class="form__label">Текст:</span>
                <div class="form__input-container">
                    <textarea 
                        ref="textInput" 
                        class="form__textarea" 
                        :name="yiiModel + '[text]'" 
                        rows="10" 
                        spellcheck="false"
                        @keyup="updatePreview"
                    >{{ text }}</textarea>
                </div>
            </div>
        </div>
        <div ref="preview" class="form__preview"></div>
        <button class="form__button">Сохранить</button>
    </form>
</template>

<script>
var marked = require('marked');
var debounce = require('lodash.debounce');

module.exports = {
    props: {
        csrfToken: {
            type: String,
            required: true  
        },
        yiiModel: {
            type: String,
            required: true
        },
        title: {
            type: String,
            default: ''
        },
        text: {
            type: String,
            default: ''
        }
    },
    mounted() {
        this.updatePreview();
    },
    methods: {
        updatePreview: debounce((function () {
            this.$refs.preview.innerHTML = marked(this.$refs.textInput.value, {
                sanitize: false
            });
        }), 200)
    }
}
</script>