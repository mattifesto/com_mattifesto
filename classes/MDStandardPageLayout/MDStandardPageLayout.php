<?php

final class MDStandardPageLayout {

    public static function render(stdClass $layoutModel, callable $renderContentCallback) {

        CBThemedMenuView::renderModelAsHTML((object)[
            'menuID' => CBStandardModels::CBMenuIDForMainMenu,
            'themeID' => CBStandardModels::CBThemeIDForCBMenuViewForMainMenu,
        ]);

        echo '<main class="MDStandardPageLayout">';

        if (empty($layoutModel->hidePageTitleAndDescriptionView)) {
            CBPageTitleAndDescriptionView::renderModelAsHTML((object)[
                'themeID' => CBStandardModels::CBThemeIDForCBPageTitleAndDescriptionView,
            ]);
        }

        $renderContentCallback();

        echo '</main>';
    }

    public static function specToModel(stdClass $spec) {
        return (object)[
            'className' => __CLASS__,
            'hidePageTitleAndDescriptionView' => CBModel::value($spec, 'hidePageTitleAndDescriptionView', null, 'boolval'),
        ];
    }
}
