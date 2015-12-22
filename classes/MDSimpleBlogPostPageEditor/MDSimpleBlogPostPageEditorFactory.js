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

        element.appendChild(MDUIPagePropertiesEditor.createSection({
            navigateCallback : args.navigateCallback,
            spec : args.spec,
            specChangedCallback : args.handleSpecChanged,
        }));

        element.appendChild(CBUI.createHalfSpace());

        element.appendChild(MDSimpleBlogPostPageEditorFactory.createPropertyEditorSection({
            properties : [
                { type : "string", name : "bodyAsMarkaround", labelText : "Content"},
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
            }

            section.appendChild(item);
        });

        return section;
    },
};

/**
 * TODO: 2015.12.20 This class should be shared and should probably become a
 * part of Colby. It's here until it settles for a while.
 */
var MDUIPagePropertiesEditor = {

    /**
     * @param function args.navigateCallback
     * @param object args.spec
     * @param function args.specChangedCallback
     *
     * @return Element
     */
    createSection : function (args) {
        var getSuggestedURICallback = MDUIPagePropertiesEditor.pageSpecToSuggestedURI.bind(undefined, args.spec);

        var editorForURIPath = CBUISuggestedStringEditor.createEditor({
            getSuggestedStringCallback : getSuggestedURICallback,
            labelText : "URI",
            navigateCallback : args.navigateCallback,
            propertyName : "URIPath",
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
        });

        var titleChangedCallback = MDUIPagePropertiesEditor.handleTitleChanged.bind(undefined, {
            specChangedCallback : args.specChangedCallback,
            suggestedURIChangedCallback : editorForURIPath.suggestedStringChangedCallback,
        });

        var publishedChangedCallback = MDUIPagePropertiesEditor.handlePublishedChanged.bind(undefined, {
            getSuggestedURICallback : getSuggestedURICallback,
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
            updateURICallback : editorForURIPath.updateValueCallback,
        });

        var item;
        var section = CBUI.createSection();

        // title
        item = CBUI.createSectionItem();
        item.appendChild(CBUIStringEditor.createEditor({
            labelText : "Title",
            propertyName : "title",
            spec : args.spec,
            specChangedCallback : titleChangedCallback,
        }).element);
        section.appendChild(item);

        // description
        item = CBUI.createSectionItem();
        item.appendChild(CBUIStringEditor.createEditor({
            labelText : "Description",
            propertyName : "description",
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
        }).element);
        section.appendChild(item);

        // URI
        item = CBUI.createSectionItem();
        item.appendChild(editorForURIPath.element);
        section.appendChild(item);

        // published
        item = CBUI.createSectionItem();
        item.appendChild(CBUIUnixTimestampEditor.createEditor({
            defaultValueText : "Not Published",
            labelText : "Published",
            navigateCallback : args.navigateCallback,
            propertyName : "published",
            spec : args.spec,
            specChangedCallback : publishedChangedCallback,
        }).element);
        section.appendChild(item);

        return section;
    },

    /**
     * @param function args.getSuggestedURICallback
     * @param object spec
     * @param function specChangedCallback
     * @param function updateURICallback
     *
     * @return undefined
     */
    handlePublishedChanged : function (args) {
        if (args.spec.published !== undefined && args.spec.URIPath === undefined) {
            var URI = args.getSuggestedURICallback.call();
            args.updateURICallback.call(undefined, URI);
        }

        args.specChangedCallback.call();
    },

    /**
     * @param function args.specChangedCallback
     * @param function args.suggestedURIChangedCallback
     *
     * @return undefined
     */
    handleTitleChanged : function (args) {
        args.suggestedURIChangedCallback.call();
        args.specChangedCallback.call();
    },

    /**
     * @param object spec
     *
     * @return string
     */
    pageSpecToSuggestedURI : function (spec) {
        var URI = "";

        if (typeof spec.title === "string") {
            URI = Colby.textToURI(spec.title);
        }

        if (URI.length < 5) {
            URI = spec.ID;
        }

        return URI;
    },
};
