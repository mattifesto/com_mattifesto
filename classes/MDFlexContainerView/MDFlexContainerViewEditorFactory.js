"use strict";

var MDFlexContainerViewEditorFactory = {

    /**
     * @param   {function}  handleSpecChanged
     * @param   {Object}    spec
     *
     * @return  {Element}
     */
    createEditor : function(args) {
        var element         = document.createElement("div");
        element.className   = "MDFlexContainerViewEditor";
        var subviews        = document.createElement("div");
        subviews.className  = "subviews";

        if (args.spec.subviews === undefined) {
            args.spec.subviews = [];
        }

        subviews.appendChild(CBSpecArrayEditorFactory.createEditor({
            array           : args.spec.subviews,
            classNames      : CBPageEditorAvailableViewClassNames,
            handleChanged   : args.handleSpecChanged
        }));

        element.appendChild(subviews);

        return element;
    }
};
