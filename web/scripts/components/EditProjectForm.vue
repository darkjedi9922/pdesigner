<template>
    <form method="post">
        <input type="hidden" name="_csrf" :value="csrfToken">
        <div class="form">
            <div class="form__content">
                <div class="form__field">
                    <span class="form__label">Название:</span>
                    <div class="form__input-container">
                        <input type="text" class="form__input" :name="yiiModel + '[name]'" spellcheck="false" :value="decodedName">
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
                            @keyup="updateDescriptionPreview"
                        >{{ decodedDescription }}</textarea>
                    </div>
                </div>
            </div>
            <div ref="preview" class="form__preview"></div>
        </div>
        <button class="form__button">Сохранить</button>
    </form>
</template>

<script>
var ProjectForm = require('./../mixins/project-form');

module.exports = {
    extends: ProjectForm,
}
</script>