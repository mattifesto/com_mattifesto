<?php

final class MDBlogPostPageLayout {

    public static function render(stdClass $layoutModel, callable $renderContentCallback) {

        CBThemedMenuView::renderModelAsHTML((object)[
            'menuID' => CBStandardModels::CBMenuIDForMainMenu,
            'themeID' => CBStandardModels::CBThemeIDForCBMenuViewForMainMenu,
        ]);

        echo '<main class="MDBlogPostPageLayout"><article>';

        if (empty($layoutModel->hidePageTitleAndDescriptionView)) {
            CBPageTitleAndDescriptionView::renderModelAsHTML((object)[
                'showPublicationDate' => true,
                'themeID' => CBStandardModels::CBThemeIDForCBPageTitleAndDescriptionView,
            ]);
        }

        $renderContentCallback();

        echo '</article></main>';
    }

    public static function specToModel(stdClass $spec) {
        return (object)[
            'className' => __CLASS__,
            'hidePageTitleAndDescriptionView' => CBModel::value($spec, 'hidePageTitleAndDescriptionView', null, 'boolval'),
        ];
    }
}
