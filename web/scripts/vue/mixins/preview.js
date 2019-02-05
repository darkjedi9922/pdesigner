var marked = require('marked');
var debounce = require('lodash.debounce');

module.exports = {
    methods: {
        updatePreview: debounce((function (srcInput, outElem) {
            var text = srcInput.value;
            outElem.innerHTML = marked(text, {
                sanitize: false
            });
        }), 200)
    }
}