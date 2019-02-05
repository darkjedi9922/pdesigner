<template>
    <form method="post">
        <input type="hidden" name="_csrf" :value="csrfToken">
        <div class="form">
            <div class="form__content">
                <div class="form__field">
                    <span class="form__label">Название:</span>
                    <div class="form__input-container">
                        <input type="text" :name="yiiModel + '[name]'" class="form__input">
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
                        ></textarea>
                    </div>
                </div>
            </div>
            <div class="form__preview" ref="preview"></div>
        </div>
        <button class="form__button">Создать проект</button>
    </form>
</template>

<script>
var YiiForm = require('./mixins/yii-form');
var marked = require('marked');
var debounce = require('lodash.debounce');

module.exports = {
    extends: YiiForm,
    methods: {
        updatePreview: debounce((function () {
            var text = this.$refs.descriptionInput.value;
            this.$refs.preview.innerHTML = marked(text, {
                sanitize: false
            });
        }), 200)
    }
};
</script>