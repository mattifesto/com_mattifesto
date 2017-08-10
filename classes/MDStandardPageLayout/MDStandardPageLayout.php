<?php

final class MDStandardPageLayout {

    /**
     * @param stdClass $layoutModel
     * @param callable $renderContentCallback
     *
     * @return null
     */
    public static function render(stdClass $layoutModel, callable $renderContentCallback) {
        $stylesID = CBModel::value($layoutModel, 'stylesID');
        $stylesCSS = CBModel::value($layoutModel, 'stylesCSS');

        $classes[] = 'MDStandardPageLayout';
        if (!empty($stylesID)) {
            $classes[] = CBTheme::IDToCSSClass($stylesID);
        }
        $classes = implode(' ', $classes);

        if (empty($stylesCSS)) {
            $styleElement = '';
        } else {
            $styleElement = "<style>{$stylesCSS}</style>";
        }

        CBPageHelpers::renderDefaultPageHeader((object)[]);

        ?>

        <main class="<?= $classes ?>" style="flex: 1 1 auto;">
            <?= $styleElement ?>

            <?php

            if (empty($layoutModel->hidePageTitleAndDescriptionView)) {
                CBView::render((object)[
                    'className' => 'CBPageTitleAndDescriptionView',
                ]);
            }

            $renderContentCallback();

            ?>

        </main>

        <?php

        CBPageHelpers::renderDefaultPageFooter((object)[]);
    }

    /**
     * @param stdClass $spec
     *
     * @return stdClass
     */
    public static function specToModel(stdClass $spec) {
        $model = (object)[
            'className' => __CLASS__,
            'hidePageTitleAndDescriptionView' => CBModel::value($spec, 'hidePageTitleAndDescriptionView', false, 'boolval'),
        ];

        if (!empty($stylesTemplate = CBModel::value($spec, 'stylesTemplate', '', 'trim'))) {
            $model->stylesID = CBHex160::random();
            $model->stylesCSS = CBTheme::stylesTemplateToStylesCSS($stylesTemplate, $model->stylesID);
        }

        return $model;
    }
}
