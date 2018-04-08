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
        CBPageFrames::installFrame(__CLASS__);
    }

    /**
     * @return [string]
     */
    static function CBInstall_requiredClassNames(): array {
        return ['CBPageFrames'];
    }

    /**
     * @param function $renderContent
     *
     * @return void
     */
    static function CBPageFrame_render(callable $renderContent): void {
        $selectedMainMenuItemName = CBModel::valueToString(CBHTMLOutput::pageInformation(), 'selectedMainMenuItemName');

        ?>

        <header class="MDPageFrame_header CBDarkTheme">
            <?php

            CBView::render((object)[
                'className' => 'CBMenuView',
                'menuID' => CBWellKnownMenuForMain::ID(),
                'selectedItemName' => $selectedMainMenuItemName,
            ]);

            ?>
        </header>

        <?php

        $renderContent();

        CBView::render((object)[
            'className' => 'MDStandardPageFooterView',
        ]);
    }
}
