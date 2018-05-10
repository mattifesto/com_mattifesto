<?php

final class CBPageHelpers {

    /**
     * @return void
     */
    static function renderDefaultPageHeader(): void {
        CBView::renderModelAsHTML((object)[
            'className' => 'MDPageHeaderView',
        ]);
    }

    /**
     * @param object $properties
     *
     * @return null
     */
    static function renderDefaultPageFooter(stdClass $properties) {
        CBView::renderModelAsHTML((object)[
            'className' => 'MDStandardPageFooterView',
        ]);
    }
}
