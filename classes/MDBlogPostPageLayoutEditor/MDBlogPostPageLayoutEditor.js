"use strict";
/* globals CBUI, CBUIBooleanEditor */

var MDBlogPostPageLayoutEditor = {

    createEditor : function (args) {
        var element = document.createElement("div");
        element.className = "MDBlogPostPageLayoutEditor";
        var section = CBUI.createSection();
        var item = CBUI.createSectionItem();

        item.appendChild(CBUIBooleanEditor.create({
            labelText : "Hide Page Title and Description View",
            propertyName : "hidePageTitleAndDescriptionView",
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
        }).element);
        section.appendChild(item);
        element.appendChild(section);

        return element;
    },
};
