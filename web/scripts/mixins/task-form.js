import htmlspecial from './../htmlspecialchars';
import YiiForm from './yii-form';
import previewMixin from'./preview';
import IssueParentsBoards from'../components/IssueParentsBoards';
    
export default {
    extends: YiiForm,
    mixins: [previewMixin],
    props: {
        title: {
            type: String,
            default: ''
        },
        text: {
            type: String,
            default: ''
        },
        parents: Array
    },
    components: { IssueParentsBoards },
    computed: {
        decodedText: function () {
            // Из PHP передаются закодированные html спецсимволы, и чтобы textarea
            // понимал их так как они были перед кодировкой (как их ввел юзер), нужно
            // декодировать их обратно.
            return htmlspecial.decode(this.text);

            // О безопасности не стоит волноваться, marked потом обрабатывает это все
            // и все "небезопасные" скрипты будут вставлены динамически, а так
            // они не выполняются.
        },
        decodedTitle: function () {
            return htmlspecial.decode(this.title);
        }
    },
    mounted() {
        this.updateTextPreview();
    },
    methods: {
        updateTextPreview() {
            this.updatePreview(this.$refs.textInput, this.$refs.preview);
        }
    }
}