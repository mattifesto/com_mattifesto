<?php

final class MDStandardPageFooterView {

    /**
     * @param hex160? $model->themeID
     *
     * @return null
     */
    public static function renderModelAsHTML(stdClass $model) {
        if (empty($model->themeID)) {
            $class = null;
        } else {
            $class = CBTheme::IDToCSSClass($model->themeID);
            CBHTMLOutput::addCSSURL(CBTheme::IDToCSSURL($model->themeID));
        }

        $year = gmdate('Y');

        ?>

        <footer class="MDStandardPageFooterView <?= $class ?>">
            Copyright &copy; <?= gmdate('Y'), ' ', CBSiteNameHTML ?>
        </footer>

        <?php
    }

    /**
     * @param stdClass $spec
     *
     * @return stdClass
     */
    public static function specToModel(stdClass $spec) {
        return (object)[
            'className' => __CLASS__,
            'themeID' => CBModel::value($spec, 'themeID'),
        ];
    }
}
