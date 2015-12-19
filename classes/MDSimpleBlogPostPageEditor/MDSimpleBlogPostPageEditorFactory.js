"use strict";

var MDSimpleBlogPostPageEditorFactory = {

    /**
     * @param function args.handleSpecChanged
     * @param object args.spec
     *
     * @return Element
     */
    createEditor : function(args) {
        var element = document.createElement("div");
        element.className = "MDSimpleBlogPostPageEditor";

        element.appendChild(CBUI.createHalfSpace());
        element.appendChild(MDSimpleBlogPostPageEditorFactory.createPropertyEditorSection({
            properties : [
                { type : "string", name : "title", labelText : "Title"},
                { type : "string", name : "description", labelText : "Description"},
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

            item.appendChild(CBUIStringEditor.createEditor({
                labelText : property.labelText,
                propertyName : property.name,
                spec : args.spec,
                specChangedCallback : args.specChangedCallback,
            }).element);

            section.appendChild(item);
        });

        return section;
    },
};
