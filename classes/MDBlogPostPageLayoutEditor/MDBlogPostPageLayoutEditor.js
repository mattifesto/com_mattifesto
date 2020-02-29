"use strict";
/* jshint strict: global */
/* jshint esversion: 6 */
/* exported MDBlogPostPageLayoutEditor */
/* global
    CBUI,
    CBUIBooleanEditor,
    CBUIStringEditor,
*/



var MDBlogPostPageLayoutEditor = {

    /* -- CBUISpecEditor interfaces -- -- -- -- -- */



    /**
     * @param object args
     *
     *      {
     *          spec: object
     *          specChangedCallback: function
     *      }
     *
     * @return Element
     */
    CBUISpecEditor_createEditorElement(
        args
    ) {
        let elements, sectionElement;
        let spec = args.spec;
        let specChangedCallback = args.specChangedCallback;

        let element = CBUI.createElement(
            "MDBlogPostPageLayoutEditor"
        );


        /* properties */

        elements = CBUI.createElementTree(
            "CBUI_sectionContainer",
            "CBUI_section"
        );

        element.appendChild(
            elements[0]
        );

        sectionElement = elements[1];


        sectionElement.appendChild(
            CBUIBooleanEditor.create(
                {
                    labelText: "Hide Page Title and Description View",
                    propertyName: "hidePageTitleAndDescriptionView",
                    spec: spec,
                    specChangedCallback: specChangedCallback,
                }
            ).element
        );


        sectionElement.appendChild(
            CBUIBooleanEditor.create(
                {
                    labelText: "Use Light Text Colors",
                    propertyName: "useLightTextColors",
                    spec: spec,
                    specChangedCallback: specChangedCallback,
                }
            ).element
        );


        sectionElement.appendChild(
            CBUIBooleanEditor.create(
                {
                    labelText: "Add Bottom Padding",
                    propertyName: "addBottomPadding",
                    spec: spec,
                    specChangedCallback: specChangedCallback,
                }
            ).element
        );


        /* local styles */

        elements = CBUI.createElementTree(
            "CBUI_sectionContainer",
            "CBUI_section"
        );

        element.appendChild(
            elements[0]
        );

        sectionElement = elements[1];

        sectionElement.appendChild(
            CBUIStringEditor.createEditor(
                {
                    labelText: "Styles Template",
                    propertyName: "stylesTemplate",
                    spec: spec,
                    specChangedCallback: specChangedCallback,
                }
            ).element
        );

        return element;
    },
    /* CBUISpecEditor_createEditorElement() */

};
