<template>
    <div class="boxes">
        <div class="boxes__item boxes__item--main">
            <issue-parents-boards :parents="parents"></issue-parents-boards>
            <div class="box">
                <form method="post" class="form">
                    <div class="form__content">
                        <input type="hidden" name="_csrf" :value="csrfToken">
                        <input v-if="parentId" type="hidden" :name="yiiModel + '[parentId]'" :value="parentId">
                        <input type="hidden" :name="yiiModel + '[groupId]'" :value="groupId">
                        <div class="form__field">
                            <span class="form__label">Название:</span>
                            <div class="form__input-container">
                                <input class="form__input" type="text" :name="yiiModel + '[title]'">
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
                                    @keyup="updateTextPreview"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    <div ref="preview" class="form__preview"></div>
                    <button class="form__button">Добавить</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import TaskForm from '../mixins/task-form';

export default {
    extends: TaskForm,
    props: {
        parentId: {
            type: Number,
            default: null
        },
        groupId: {
            type: Number,
            required: true
        }
    }
}
</script>