<?php

final class CBPageHelpers {

    /**
     * @return void
     */
    static function renderDefaultPageHeader(): void {
        CBView::render(
            (object)[
                'className' => 'MDPageHeaderView',
            ]
        );
    }


    /**
     * @param object $properties
     *
     * @return void
     */
    static function renderDefaultPageFooter(stdClass $properties): void {
        CBView::render(
            (object)[
                'className' => 'MDStandardPageFooterView',
            ]
        );
    }
}
