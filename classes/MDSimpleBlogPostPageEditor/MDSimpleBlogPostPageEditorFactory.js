"use strict";

var MDSimpleBlogPostPageEditorFactory = {

    /**
     * @param function args.handleSpecChanged
     * @param function args.navigateCallback
     * @param object args.spec
     *
     * @return Element
     */
    createEditor : function(args) {
        var element = document.createElement("div");
        element.className = "MDSimpleBlogPostPageEditor";

        element.appendChild(CBUI.createHalfSpace());
        element.appendChild(MDSimpleBlogPostPageEditorFactory.createPropertyEditorSection({
            navigateCallback : args.navigateCallback,
            properties : [
                { type : "string", name : "title", labelText : "Title"},
                { type : "string", name : "description", labelText : "Description"},
                { type : "timestamp", name : "published", labelText : "Published", defaultValueText : "Not Published"},
            ],
            spec : args.spec,
            specChangedCallback : args.handleSpecChanged,
        }));
        element.appendChild(CBUI.createHalfSpace());
        element.appendChild(MDSimpleBlogPostPageEditorFactory.createPropertyEditorSection({
            properties : [
                { type : "string", name : "content", labelText : "Content"},
            ],
            spec : args.spec,
            specChangedCallback : args.handleSpecChanged,
        }));
        element.appendChild(CBUI.createHalfSpace());

        return element;
    },

    /**
     * @param function args.navigateCallback
     * @param [object] args.properties
     * @param object args.spec
     * @param function args.specChangedCallback
     *
     * @return Element
     */
    createPropertyEditorSection : function (args) {
        var section = CBUI.createSection();

        args.properties.forEach(function (property) {
            var item = CBUI.createSectionItem();

            switch (property.type) {
                case "string":
                    item.appendChild(CBUIStringEditor.createEditor({
                        labelText : property.labelText,
                        propertyName : property.name,
                        spec : args.spec,
                        specChangedCallback : args.specChangedCallback,
                    }).element);
                    break;
                case "timestamp":
                    item.appendChild(CBUIUnixTimestampEditor.createEditor({
                        defaultValueText : property.defaultValueText,
                        labelText : property.labelText,
                        navigateCallback : args.navigateCallback,
                        propertyName : property.name,
                        spec : args.spec,
                        specChangedCallback : args.specChangedCallback,
                    }).element);
                    break;
            }

            section.appendChild(item);
        });

        return section;
    },
};
