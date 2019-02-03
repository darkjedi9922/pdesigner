import Vue from 'vue';

Vue.config.productionTip = false;

/**
 * Creates an Vue App instance from Vue Component.  
 */
module.exports = function(vueComponent, selector, props) {
    props = props || {};
    var elements = document.querySelectorAll(selector);
    elements.forEach((el) => {
        new Vue({
            el: el,
            components: { vueComponent },
            render: function (createElement) {
                return createElement(vueComponent, {
                    props: props
                });
            }
        });
    })
}