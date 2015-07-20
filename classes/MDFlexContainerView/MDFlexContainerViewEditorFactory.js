"use strict";

var MDFlexContainerViewEditorFactory = {

    /**
     * @param   {function}  handleSpecChanged
     * @param   {Object}    spec
     *
     * @return  {Element}
     */
    createEditor : function(args) {
        var element             = document.createElement("div");
        element.className       = "MDFlexContainerViewEditor";
        var container           = document.createElement("div");
        container.className     = "container";
        var preview             = CBImageEditorFactory.createImagePreviewElement();
        preview.img.src         = args.spec.imageURL || "";
        var options             = document.createElement("div");
        options.className       = "options";
        var background          = document.createElement("h2");
        background.textContent  = "Background";
        var flexbox             = document.createElement("h2");
        flexbox.textContent     = "Flexbox";
        var subviews            = document.createElement("div");
        subviews.className      = "subviews";

        container.appendChild(preview.element);

        options.appendChild(CBStringEditorFactory.createSelectEditor({
            data                : [
                { textContent : "div",      value : "" },
                { textContent : "article",  value : "article" },
                { textContent : "main",     value : "main" }
            ],
            handleSpecChanged   : args.handleSpecChanged,
            labelText           : "Type",
            propertyName        : "type",
            spec                : args.spec
        }));

        options.appendChild(background);
        options.appendChild(flexbox);
        container.appendChild(options);

        if (args.spec.subviews === undefined) {
            args.spec.subviews = [];
        }

        subviews.appendChild(CBSpecArrayEditorFactory.createEditor({
            array           : args.spec.subviews,
            classNames      : CBPageEditorAvailableViewClassNames,
            handleChanged   : args.handleSpecChanged
        }));

        element.appendChild(container);
        element.appendChild(subviews);

        return element;
    }
};
