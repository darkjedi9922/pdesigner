import Vue from 'vue';
import taskMixin from '../mixins/task';
import markMixin from '../mixins/mark';
import TodoStatusIcon from '../components/TodoStatusIcon';

new Vue({
    el: '#issue-app',
    mixins: [taskMixin, markMixin],
    components: { TodoStatusIcon },
    data: function() {
        return {
            id: 0,
            status: 0,
            token: ''
        }
    },
    mounted: function() {
        this.markdown('.issue__text');
    }
});