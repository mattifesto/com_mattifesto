"use strict";

var MDSimpleBlogPostPagePreferencesEditor = {

    /**
     * @param function args.handleSpecChanged
     * @param function args.navigateCallback
     * @param object args.spec
     *
     * @return Element
     */
    createEditor : function (args) {
        var section, item;
        var element = document.createElement("div");
        element.className = "MDSimpleBlogPostPageEditor";

        element.appendChild(CBUI.createHalfSpace());

        section = CBUI.createSection();

        // defaultContainerThemeID

        item = CBUI.createSectionItem();
        item.appendChild(CBUISelector.create({
            labelText : "Default Container Theme",
            navigateCallback : args.navigateCallback,
            propertyName : "defaultContainerThemeID",
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
            options : CBContainerViewThemes,
        }).element);

        section.appendChild(item);

        // defaultContentThemeID

        item = CBUI.createSectionItem();
        item.appendChild(CBUISelector.create({
            labelText : "Default Content Theme",
            navigateCallback : args.navigateCallback,
            propertyName : "defaultContentThemeID",
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
            options : CBTextViewThemes,
        }).element);

        section.appendChild(item);

        // defaulHeaderThemeID

        item = CBUI.createSectionItem();
        item.appendChild(CBUISelector.create({
            labelText : "Default Header Theme",
            navigateCallback : args.navigateCallback,
            propertyName : "defaultHeaderThemeID",
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
            options : CBHeaderTextViewThemes,
        }).element);

        section.appendChild(item);

        // defaultMenuThemeID

        item = CBUI.createSectionItem();
        item.appendChild(CBUISelector.create({
            labelText : "Default Menu Theme",
            navigateCallback : args.navigateCallback,
            propertyName : "defaultMenuThemeID",
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
            options : CBMenuViewThemes,
        }).element);

        section.appendChild(item);
        element.appendChild(section);

        element.appendChild(CBUI.createHalfSpace());

        return element;
    }
};
