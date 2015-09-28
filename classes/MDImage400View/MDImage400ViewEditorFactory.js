"use strict";

var MDImage400ViewEditorFactory = {

    /**
     * @return {Element}
     */
    createEditor : function (args) {
        var element = document.createElement("div");
        element.className = "MDImage400ViewEditor";

        element.appendChild(CBImageEditorFactory.createImageIDEditor({
            handleSpecChanged : args.handleSpecChanged,
            propertyName : "image",
            spec : args.spec
        }));

        return element;
    }
};
