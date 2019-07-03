import Vue from 'vue';

Vue.config.productionTip = false;

/**
 * Creates an Vue App instance from Vue Component.  
 */
export default function(vueComponent, selector, props) {
    props = props || {};
    var elements = document.querySelectorAll(selector);
    elements.forEach((el) => {
        new Vue({
            el: el,
            render: function (createElement) {
                return createElement(vueComponent, {
                    props: props
                });
            }
        });
    })
}