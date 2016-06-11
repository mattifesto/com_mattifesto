<?php

final class MDStandardPageLayout {

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

        echo '<main class="MDStandardPageLayout">';

        if (empty($layoutModel->hidePageTitleAndDescriptionView)) {
            CBPageTitleAndDescriptionView::renderModelAsHTML((object)[]);
        }

        $renderContentCallback();

        echo '</main>';

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
