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
     * @param object $spec
     *
     * @return object
     */
    static function CBModel_build(stdClass $spec): stdClass {
        $model = (object)[
            'hidePageTitleAndDescriptionView' => CBModel::valueToBool(
                $spec,
                'hidePageTitleAndDescriptionView'
            ),
        ];

        $stylesTemplate = trim(
            CBModel::valueToString($spec, 'stylesTemplate')
        );

        if (!empty($stylesTemplate)) {
            $model->stylesID = CBID::generateRandomCBID();
            $localCSSClassName = "T{$model->stylesID}";
            $model->stylesCSS = CBView::localCSSTemplateToLocalCSS(
                $stylesTemplate,
                'view',
                ".{$localCSSClassName}"
            );
        }

        return $model;
    }
    /* CBModel_build() */
}
