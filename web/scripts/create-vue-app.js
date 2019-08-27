import Vue from 'vue';
import store from './store';

Vue.config.productionTip = false;

/**
 * Creates an Vue App instance from Vue Component.  
 */
export default function(vueComponent, selector, props) {
    props = props || {};
    var elements = document.querySelectorAll(selector);
    elements.forEach((el) => {
        new Vue({
            el,
            store,
            render: function (createElement) {
                return createElement(vueComponent, {
                    props: props
                });
            }
        });
    })
}