import Vue from 'vue';
import taskMixin from '../mixins/task';
import markMixin from '../mixins/mark';
import VueCheckbox from '../components/vue-checkbox';

new Vue({
    el: '#issue-app',
    mixins: [taskMixin, markMixin],
    components: { VueCheckbox },
    data: function() {
        return {
            id: 0,
            checked: false,
            token: ''
        }
    },
    mounted: function() {
        this.markdown('.issue__text');
    },
    methods: {
        switchChecked: function() {
            this.checked = !this.checked;
            this.setTaskChecked(this.id, this.checked, this.token);
        }
    }
});