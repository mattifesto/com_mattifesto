<?php

final class MDFloatingHeaderView {

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
