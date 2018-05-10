<?php

final class MDPageFrame {

    /**
     * @return [string]
     */
    static function CBHTMLOutput_CSSURLs(): array {
        return [Colby::flexpath(__CLASS__, 'css', cbsiteurl())];
    }

    /**
     * @return void
     */
    static function CBInstall_install(): void {
        CBPageFrameCatalog::install(__CLASS__);
    }

    /**
     * @return [string]
     */
    static function CBInstall_requiredClassNames(): array {
        return ['CBPageFrameCatalog'];
    }

    /**
     * @param function $renderContent
     *
     * @return void
     */
    static function CBPageFrame_render(callable $renderContent): void {
        CBView::render((object)[
            'className' => 'MDPageHeaderView',
        ]);

        $renderContent();

        CBView::render((object)[
            'className' => 'MDStandardPageFooterView',
        ]);
    }
}
