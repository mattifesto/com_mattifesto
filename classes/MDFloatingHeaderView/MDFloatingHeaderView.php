<?php

final class MDFloatingHeaderView {

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
        $model                          = MDModels::modelWithClassName(__CLASS__);
        $model->color                   = isset($spec->color) ? trim($spec->color) : '';
        $model->selectedMenuItemName    = isset($spec->selectedMenuItemName) ? trim($spec->selectedMenuItemName) : '';

        return $model;
    }
}
