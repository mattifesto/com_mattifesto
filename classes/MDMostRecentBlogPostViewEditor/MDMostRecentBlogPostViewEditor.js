"use strict";
/* jshint strict: global */
/* jshint esversion: 6 */
/* exported MDMostRecentBlogPostViewEditor */
/* globals
    CBUI,
*/



var MDMostRecentBlogPostViewEditor = {

    /**
     * @return Element
     */
    CBUISpecEditor_createEditorElement() {
        let elements = CBUI.createElementTree(
            "MDMostRecentBlogPostViewEditor",
            "CBUI_sectionContainer",
            "CBUI_section",
            "CBUI_container_topAndBottom",
            "MDMostRecentBlogPostViewEditor_text CBUI_textAlign_center"
        );

        let element = elements[0];

        elements[4].textContent = "This view has no editable properties.";

        return element;
    },
    /* CBUISpecEditor_createEditorElement() */

};
