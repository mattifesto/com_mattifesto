<?php

final class MDPageHeaderView {

    /**
     * @return [string]
     */
    static function CBHTMLOutput_CSSURLs() {
        return [Colby::flexpath(__CLASS__, 'v110.css', cbsiteurl())];
    }

    /**
     * @param model $model
     *
     * @return void
     */
    static function CBView_render(stdClass $model): void {
        $selectedMainMenuItemName = CBModel::valueToString(
            CBHTMLOutput::pageInformation(),
            'selectedMainMenuItemName'
        );

        ?>

        <header class="MDPageHeaderView CBDarkTheme">
            <?php

            CBView::render((object)[
                'className' => 'CBMenuView',
                'menuID' => MDMainMenu::ID(),
                'selectedItemName' => $selectedMainMenuItemName,
            ]);

            ?>
        </header>

        <?php
    }
}
