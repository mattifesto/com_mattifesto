"use strict"; /* jshint strict: global */
/* globals
    CBUI */

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

        element.appendChild(CBUI.createSectionHeader({
            paragraphs: ["There are no editable properties."],
        }));

        return element;
    }
};
