<?php

final class MDStandardPageLayout {

    /**
     * @param stdClass $layoutModel
     * @param callable $renderContentCallback
     *
     * @return null
     */
    static function render(stdClass $layoutModel, callable $renderContentCallback) {
        $stylesID = CBModel::value($layoutModel, 'stylesID');
        $stylesCSS = CBModel::value($layoutModel, 'stylesCSS');

        $classes[] = 'MDStandardPageLayout';

        if (!empty($stylesID)) {
            $classes[] = "T{$stylesID}";
        }

        $classes = implode(' ', $classes);

        CBHTMLOutput::addCSS($stylesCSS);
        CBPageLayout::renderPageHeader();

        ?>

        <main class="<?= $classes ?>" style="flex: 1 1 auto;">
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
    static function CBModel_toModel(stdClass $spec) {
        $model = (object)[
            'className' => __CLASS__,
            'hidePageTitleAndDescriptionView' => CBModel::value($spec, 'hidePageTitleAndDescriptionView', false, 'boolval'),
        ];

        if (!empty($stylesTemplate = CBModel::value($spec, 'stylesTemplate', '', 'trim'))) {
            $model->stylesID = CBHex160::random();
            $localCSSClassName = "T{$model->stylesID}";
            $model->stylesCSS = CBView::localCSSTemplateToLocalCSS($stylesTemplate, 'view', ".{$localCSSClassName}");
        }

        return $model;
    }
}
