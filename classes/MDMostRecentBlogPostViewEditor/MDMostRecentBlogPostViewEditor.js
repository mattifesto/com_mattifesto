"use strict";
/* jshint strict: global */
/* exported MDMostRecentBlogPostViewEditor */
/* globals
    CBUI */

var MDMostRecentBlogPostViewEditor = {

    /**
     * @param object args
     *
     * @return Element
     */
    createEditor: function (args) {
        var element = document.createElement("div");
        element.className = "MDMostRecentBlogPostViewEditor";

        element.appendChild(CBUI.createHalfSpace());

        var section = CBUI.createSection();
        var item = CBUI.createSectionItem3();
        var part = CBUI.createMessageSectionItemPart({
            message: "There are no editable properties.",
        });

        item.appendPart(part);
        section.appendChild(item.element);
        element.appendChild(section);

        element.appendChild(CBUI.createHalfSpace());

        return element;
    },
};
