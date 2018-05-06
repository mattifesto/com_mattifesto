<?php

final class CBPageHelpers {

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
