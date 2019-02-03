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
                    <textarea class="form__textarea" :name="yiiModel + '[text]'" rows="10" spellcheck="false">{{ text }}</textarea>
                </div>
            </div>
        </div>
        <button class="form__button">Сохранить</button>
    </form>
</template>

<script>
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
    }
}
</script>