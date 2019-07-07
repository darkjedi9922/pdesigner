import Vue from 'vue';
import Component from 'vue-class-component';
import marked from 'marked';

@Component
export default class MarkMixin extends Vue {
    /**
     * Применяет markdown форматирование к первому элементу с заданным селектором,
     * которые находятся внутри элемента экземпляра Vue
     */
    markdown(selector: string): void {
        var textElement = this.$el.querySelector(selector) as any;
        if (textElement) textElement.innerHTML = marked(textElement.innerText, { 
            sanitize: false 
        });
    }
}