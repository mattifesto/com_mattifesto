<?php

final class MDPageHeaderView {

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
