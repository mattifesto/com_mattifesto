"use strict";

var MDBodyTextViewEditorFactory = {
    createEditor : function(args) {
        var element         = document.createElement("div");
        element.className   = "MDBodyTextViewEditor";

        element.appendChild(CBResponsiveEditorFactory.createStringEditorWithTextArea({
            handleSpecChanged   : args.handleSpecChanged,
            labelText           : "Title",
            spec                : args.spec,
            propertyName        : "title"
        }));

        element.appendChild(CBResponsiveEditorFactory.createStringEditorWithTextArea({
            handleSpecChanged   : args.handleSpecChanged,
            labelText           : "Content",
            spec                : args.spec,
            propertyName        : "contentAsMarkaround"
        }));

        return element;
    }
}
