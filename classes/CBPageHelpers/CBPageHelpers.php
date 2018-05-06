<?php

final class CBPageHelpers {

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
     * @param object $properties
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
