"use strict";

var MDFloatingHeaderViewEditorFactory = {

    menuItems           : [],
    menuItemsUpdated    : "MDFloatingHeaderViewEditorMenuItemsUpdated",

    /**
     * @param   {function}  handleSpecChanged
     * @param   {Object}    spec
     *
     * @return  {Element}
     */
    createEditor : function(args) {
        var element         = document.createElement("div");
        element.className   = "MDFloatingHeaderViewEditor";

        element.appendChild(CBStringEditorFactory.createSelectEditor({
            className           : "select",
            data                : MDFloatingHeaderViewEditorFactory.menuItems,
            dataUpdatedEvent    : MDFloatingHeaderViewEditorFactory.menuItemsUpdated,
            handleSpecChanged   : args.handleSpecChanged,
            labelText           : "Selected Menu Item",
            propertyName        : "selectedMenuItemName",
            spec                : args.spec
        }));

        element.appendChild(CBStringEditorFactory.createSingleLineEditor({
            handleSpecChanged   : args.handleSpecChanged,
            labelText           : "Color",
            propertyName        : "color",
            spec                : args.spec
        }));

        return element;
    },

    /**
     * @return undefined
     */
    fetchMenu : function() {
        var xhr     = new XMLHttpRequest();
        xhr.onload  = MDFloatingHeaderViewEditorFactory.fetchMenuCompleted.bind(undefined, {
            xhr : xhr
        });
        xhr.onerror = function() {
            alert('The MDFloatingHeaderView menu failed to load.');
        };

        xhr.open("POST", '/api/?class=MDFloatingHeaderView&function=fetchMenu');
        xhr.send();
    },

    /**
     * @param   {XMLHttpRequest}    xhr
     *
     * @return  undefined
     */
    fetchMenuCompleted : function(args) {
        var response = Colby.responseFromXMLHttpRequest(args.xhr);

        if (response.wasSuccessful) {
            var menuItems       = MDFloatingHeaderViewEditorFactory.menuItems;
            menuItems.length    = 0;

            menuItems.push({ textContent : "None", value : ""});

            response.menu.items.forEach(function(item) {
                menuItems.push({textContent : item.text, value : item.name});
            });

            document.dispatchEvent(new Event(MDFloatingHeaderViewEditorFactory.menuItemsUpdated));
        } else {
            Colby.displayResponse(response);
        }
    }
};

document.addEventListener("DOMContentLoaded", function() {
    MDFloatingHeaderViewEditorFactory.fetchMenu();
});
