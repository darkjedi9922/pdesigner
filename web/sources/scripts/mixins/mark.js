var markMixin = {
    methods: {
        /**
         * Применяет markdown форматирование к первому элементу с заданным селектором,
         * которые находятся внутри элемента экземпляра Vue
         */
        markdown: function(selector) {
            var textElement = this.$el.querySelector(selector);
            if (textElement) textElement.innerHTML = marked(textElement.innerText, { sanitize: false });
        }
    }
}