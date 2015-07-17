<?php

final class MDFloatingHeaderView {

    /**
     * @return [<hex160>]
     */
    public static function modelToModelDependencies(stdClass $model) {
        return [CBMainMenu::ID];
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
