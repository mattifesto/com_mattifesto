<?php

final class CBPageHelpers {

    /**
     * @return [string]
     */
    static function classNamesForPageTemplates() {
        return array_merge(['MDBlogPostPageTemplate'], CBPagesPreferences::defaultClassNamesForPageTemplates);
    }

    /**
     * @param stdClass $properties
     *
     * @return null
     */
    static function renderDefaultPageFooter(stdClass $properties) {
        CBView::renderModelAsHTML((object)[
            'className' => 'MDStandardPageFooterView',
            'hideFlexboxFill' => true,
        ]);
    }

    /**
     * @param stdClass $properties
     *
     * @return null
     */
    static function renderDefaultPageHeader(stdClass $properties) {
        CBView::renderModelAsHTML((object)[
            'className' => 'CBThemedMenuView',
            'menuID' => CBStandardModels::CBMenuIDForMainMenu,
            'themeID' => CBStandardModels::CBThemeIDForCBMenuViewForMainMenu,
        ]);
    }
}
