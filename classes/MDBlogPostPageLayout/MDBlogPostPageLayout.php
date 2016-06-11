<?php

final class MDBlogPostPageLayout {

    /**
     * @param stdClass $layoutModel
     * @param callable $renderContentCallback
     *
     * @return null
     */
    public static function render(stdClass $layoutModel, callable $renderContentCallback) {

        CBThemedMenuView::renderModelAsHTML((object)[
            'menuID' => CBStandardModels::CBMenuIDForMainMenu,
            'themeID' => CBStandardModels::CBThemeIDForCBMenuViewForMainMenu,
        ]);

        echo '<main class="MDBlogPostPageLayout"><article>';

        if (empty($layoutModel->hidePageTitleAndDescriptionView)) {
            CBPageTitleAndDescriptionView::renderModelAsHTML((object)[
                'showPublicationDate' => true,
            ]);
        }

        $renderContentCallback();

        echo '</article></main>';

        MDStandardPageFooterView::renderModelAsHTML();
    }

    /**
     * @param stdClass $spec
     *
     * @return stdClass
     */
    public static function specToModel(stdClass $spec) {
        return (object)[
            'className' => __CLASS__,
            'hidePageTitleAndDescriptionView' => CBModel::value($spec, 'hidePageTitleAndDescriptionView', null, 'boolval'),
        ];
    }
}
