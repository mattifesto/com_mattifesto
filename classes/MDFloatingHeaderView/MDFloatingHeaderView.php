<?php

final class MDFloatingHeaderView {

    /**
     * @return [{string}]
     */
    public static function editorURLsForJavaScript() {
        return [
            CBSystemURL . '/javascript/CBStringEditorFactory.js',
            MDFloatingHeaderView::URL('MDFloatingHeaderViewEditorFactory.js')
        ];
    }

    /**
     * @return [<hex160>]
     */
    public static function modelToModelDependencies(stdClass $model) {
        return [CBMainMenu::ID];
    }

    /**
     * @return null
     */
    public static function renderModelAsHTML(stdClass $model) {
        echo '<header></header>';
    }

    /**
     * @return {stdClass}
     */
    public static function specToModel(stdClass $spec) {
        $model                          = CBModels::modelWithClassName(__CLASS__);
        $model->color                   = isset($spec->color) ? trim($spec->color) : '';
        $model->selectedMenuItemName    = isset($spec->selectedMenuItemName) ? trim($spec->selectedMenuItemName) : '';

        return $model;
    }

    /**
     * @return string
     */
    public static function URL($filename) {
        return CBSiteURL . "/classes/MDFloatingHeaderView/{$filename}";
    }
}
