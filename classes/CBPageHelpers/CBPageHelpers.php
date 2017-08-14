<?php

final class CBPageHelpers {

    /**
     * @return string
     */
    static function classNameForUnsetPageSettings() {
        return 'MDPageSettingsForResponsivePages';
    }

    /**
     * @return [string]
     */
    static function classNamesForPageKinds() {
        return array_merge(
            CBPagesPreferences::classNamesForPageKindsDefault(),
            ['MDBlogPostPageKind']
        );
    }

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
}
