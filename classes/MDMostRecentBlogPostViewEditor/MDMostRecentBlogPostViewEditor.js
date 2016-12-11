"use strict"; /* jshint strict: global */
/* globals
    CBUI,
    CBUIBooleanEditor */

var MDMostRecentBlogPostViewEditor = {

    /**
     * @param object spec
     * @param function specChangedCallback
     *
     * @return Element
     */
    createEditor : function (args) {
        var section, item;
        var element = document.createElement("div");
        element.className = "MDMostRecentBlogPostViewEditor";

        section = CBUI.createSection();

        item = CBUI.createSectionItem();
        item.appendChild(CBUIBooleanEditor.create({
            labelText: "Use Light Text Colors",
            propertyName: "useLightTextColors",
            spec: args.spec,
            specChangedCallback: args.specChangedCallback,
        }).element);
        section.appendChild(item);
        element.appendChild(section);

        return element;
    }
};
