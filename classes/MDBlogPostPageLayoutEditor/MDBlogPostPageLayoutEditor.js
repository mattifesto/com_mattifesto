"use strict"; /* jshint strict: global */
/* globals CBUI, CBUIBooleanEditor, CBUIStringEditor */

var MDBlogPostPageLayoutEditor = {

    /**
     *
     */
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

        item = CBUI.createSectionItem();
        item.appendChild(CBUIBooleanEditor.create({
            labelText: "Use Light Text Colors",
            propertyName: "useLightTextColors",
            spec: args.spec,
            specChangedCallback: args.specChangedCallback,
        }).element);
        section.appendChild(item);

        item = CBUI.createSectionItem();
        item.appendChild(CBUIBooleanEditor.create({
            labelText: "Add Bottom Padding",
            propertyName: "addBottomPadding",
            spec: args.spec,
            specChangedCallback: args.specChangedCallback,
        }).element);
        section.appendChild(item);
        element.appendChild(section);

        /* local styles */

        element.appendChild(CBUI.createHalfSpace());

        section = CBUI.createSection();
        item = CBUI.createSectionItem();
        item.appendChild(CBUIStringEditor.createEditor({
            labelText : "Styles Template",
            propertyName : "stylesTemplate",
            spec : args.spec,
            specChangedCallback : args.specChangedCallback,
        }).element);
        section.appendChild(item);
        element.appendChild(section);

        return element;
    },
};
