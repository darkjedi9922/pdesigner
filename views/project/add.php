<div class="breadcrumb">
    <span class="breadcrumb__section">Новый проект</span>
</div>
<div class="box">
    <form method="post">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
        <div class="form form--table">
            <div class="form__field">
                <span class="form__label">Название:</span>
                <div class="form__input-container">
                    <input type="text" name="AddProjectForm[name]" class="form__input">
                </div>
            </div>
            <div class="form__field">
                <span class="form__label">Описание:</span>
                <div class="form__input-container">
                    <textarea class="form__textarea" name="AddProjectForm[description]" rows="10" spellcheck="false"></textarea>
                </div>
            </div>
        </div>
        <br><button class="form__button">Создать проект</button>
    </form>
</div>