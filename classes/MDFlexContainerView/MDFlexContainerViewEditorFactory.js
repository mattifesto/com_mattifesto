"use strict";

var MDFlexContainerViewEditorFactory = {

    /**
     * @param   {function}  handleSpecChanged
     * @param   {Object}    spec
     *
     * @return  {Element}
     */
    createEditor : function(args) {
        var row;
        var element             = document.createElement("div");
        element.className       = "MDFlexContainerViewEditor";
        var container           = document.createElement("div");
        container.className     = "container";
        var preview             = CBImageEditorFactory.createImagePreviewElement();
        preview.img.src         = args.spec.imageURL || "";
        var options             = document.createElement("div");
        options.className       = "options";
        var flexbox             = document.createElement("h2");
        flexbox.textContent     = "Flexbox";
        var subviews            = document.createElement("div");
        subviews.className      = "subviews";

        container.appendChild(preview.element);

        options.appendChild(CBStringEditorFactory.createSelectEditor({
            data                : [
                { textContent : "div",      value : "" },
                { textContent : "article",  value : "article" },
                { textContent : "main",     value : "main" }
            ],
            handleSpecChanged   : args.handleSpecChanged,
            labelText           : "Type",
            propertyName        : "type",
            spec                : args.spec
        }));

        /* background section */

        var background          = document.createElement("h2");
        background.textContent  = "Background";

        options.appendChild(background);

        row                 = document.createElement("div");
        row.className       = "row";
        var clear           = document.createElement("button");
        clear.textContent   = "Clear Image";
        var size            = document.createElement("div");
        size.className      = "size";
        var upload          = CBImageEditorFactory.createEditorUploadButton({
            handleImageUploaded     : MDFlexContainerViewEditorFactory.handleImageUploaded.bind(undefined, {
                handleSpecChanged   : args.handleSpecChanged,
                previewImageElement : preview.img,
                sizeElement         : size,
                spec                : args.spec
            })
        });

        clear.addEventListener("click", MDFlexContainerViewEditorFactory.handleClearImage.bind(undefined, {
            handleSpecChanged   : args.handleSpecChanged,
            previewImageElement : preview.img,
            sizeElement         : size,
            spec                : args.spec
        }));

        MDFlexContainerViewEditorFactory.displaySize({
            sizeElement : size,
            spec        : args.spec
        });

        MDFlexContainerViewEditorFactory.displayThumbnail({
            previewImageElement : preview.img,
            spec                : args.spec
        });

        row.appendChild(upload);
        row.appendChild(size);
        row.appendChild(clear);
        options.appendChild(row);


        /* flexbox section */

        options.appendChild(flexbox);

        container.appendChild(options);

        if (args.spec.subviews === undefined) {
            args.spec.subviews = [];
        }

        subviews.appendChild(CBSpecArrayEditorFactory.createEditor({
            array           : args.spec.subviews,
            classNames      : CBPageEditorAvailableViewClassNames,
            handleChanged   : args.handleSpecChanged
        }));

        element.appendChild(container);
        element.appendChild(subviews);

        return element;
    },

    /**
     * @param   {Element}   sizeElement
     * @param   {Object}    spec
     *
     * @return  undefined
     */
    displaySize : function(args) {
        if (args.spec.imageHeight === undefined || args.spec.imageWidth === undefined) {
            args.sizeElement.textContent = "no image";
        } else {
            args.sizeElement.textContent = args.spec.imageWidth + " × " + args.spec.imageHeight;
        }
    },

    /**
     * @param   {Element}   previewImageElement
     * @param   {Object}    spec
     *
     * @return  undefined
     */
    displayThumbnail : function(args) {
        if (args.spec.imageURL === undefined) {
            args.previewImageElement.style.visibility   = "hidden";
        } else {
            args.previewImageElement.src                = args.spec.imageURL;
            args.previewImageElement.style.visibility   = "visible";
        }
    },

    /**
     * @param   {function}  handleSpecChanged
     * @param   {Element}   previewImageElement
     * @param   {Element}   sizeElement
     * @param   {Object}    spec
     */
    handleClearImage : function(args) {
        args.spec.imageHeight           = undefined;
        args.spec.imageURL              = undefined;
        args.spec.imageWidth            = undefined;

        MDFlexContainerViewEditorFactory.displaySize({
            sizeElement : args.sizeElement,
            spec        : args.spec
        });

        MDFlexContainerViewEditorFactory.displayThumbnail({
            previewImageElement : args.previewImageElement,
            spec                : args.spec
        });

        args.handleSpecChanged.call();
    },

    /**
     * @param   {function}  handleSpecChanged
     * @param   {Element}   previewImageElement
     * @param   {Element}   sizeElement
     * @param   {Object}    spec
     */
    handleImageUploaded : function(args, response) {
        args.spec.imageHeight           = response.sizes.original.height;
        args.spec.imageURL              = response.sizes.original.URL;
        args.spec.imageWidth            = response.sizes.original.width;

        MDFlexContainerViewEditorFactory.displaySize({
            sizeElement : args.sizeElement,
            spec        : args.spec
        });

        MDFlexContainerViewEditorFactory.displayThumbnail({
            previewImageElement : args.previewImageElement,
            spec                : args.spec
        });

        args.handleSpecChanged.call();
    }
};
