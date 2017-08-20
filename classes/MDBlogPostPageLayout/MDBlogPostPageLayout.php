<?php

/**
 * This class performs two related functions:
 *
 * 1. It's original purpose was as a page layout and it will continue to serve
 *    that purpose for pages already using it. It has been deprecated for this
 *    purpose. Eventually we will replace this layout on pages that use it and
 *    remove this functionality from the class.
 *
 * 2. It is the customLayoutClassName class for new blog posts created using the
 *    CBPageLayout layout class. It has the option in the future to implement
 *    custom layout functionality for blog posts. For instances, adding a blog
 *    specific header menu.
 */
final class MDBlogPostPageLayout {

    /**
     * @param bool? $layoutModel->addBottomPadding
     * @param bool? $layoutModel->hidePageTitleAndDescriptionView
     * @param hex160? $layoutModel->stylesID
     * @param string? $layoutModel->stylesCSS
     * @param bool? $layoutModel->useLightTextColors
     *
     * @param callable $renderContentCallback
     *
     * @return null
     */
    static function render(stdClass $layoutModel, callable $renderContentCallback) {
        $stylesID = CBModel::value($layoutModel, 'stylesID');
        $stylesCSS = CBModel::value($layoutModel, 'stylesCSS');

        $classes[] = 'MDBlogPostPageLayout';

        if (!empty($stylesID)) {
            $classes[] = "T{$stylesID}";
        }

        $classes = implode(' ', $classes);

        CBHTMLOutput::addCSS($stylesCSS);
        CBPageLayout::renderPageHeader();

        $styles[] = 'flex: 1 1 auto';

        if (!empty($layoutModel->addBottomPadding)) {
            $styles[] = 'padding-bottom: 100px';
        }

        $styles = implode('; ', $styles);

        ?>

        <main class="<?= $classes ?>" style="<?= $styles ?>">
            <article>

                <?php

                if (empty($layoutModel->hidePageTitleAndDescriptionView)) {
                    CBView::render((object)[
                        'className' => 'CBPageTitleAndDescriptionView',
                        'showPublicationDate' => true,
                        'useLightTextColors' => !empty($layoutModel->useLightTextColors),
                    ]);
                }

                $renderContentCallback();

                ?>

            </article>
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
            'addBottomPadding' => CBModel::value($spec, 'addBottomPadding', false, 'boolval'),
            'hidePageTitleAndDescriptionView' => CBModel::value($spec, 'hidePageTitleAndDescriptionView', false, 'boolval'),
            'useLightTextColors' => CBModel::value($spec, 'useLightTextColors', false, 'boolval'),
        ];

        if (!empty($stylesTemplate = CBModel::value($spec, 'stylesTemplate', '', 'trim'))) {
            $model->stylesID = CBHex160::random();
            $localCSSClassName = "T{$model->stylesID}";
            $model->stylesCSS = CBView::localCSSTemplateToLocalCSS($stylesTemplate, 'view', ".{$localCSSClassName}");
        }

        return $model;
    }
}
