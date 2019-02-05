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
                            @keyup="updateDescriptionPreview"
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
var ProjectForm = require('./mixins/project-form');

module.exports = {
    extends: ProjectForm,
}
</script>