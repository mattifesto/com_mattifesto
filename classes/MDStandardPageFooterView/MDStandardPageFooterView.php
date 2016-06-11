<?php

final class MDStandardPageFooterView {

    /**
     * @param hex160? $model->themeID
     *
     * @return null
     */
    public static function renderModelAsHTML(stdClass $model = null) {
        if (empty($themeID = CBModel::value($model, 'themeID'))) {
            $themeID = MDWellKnownThemeForFooter::ID;
        }

        CBTheme::useThemeWithID($themeID);

        $class = CBTheme::IDToCSSClass($themeID);
        $year = gmdate('Y');

        ?>

        <div style="flex: 1 1 auto"></div>
        <footer class="MDStandardPageFooterView <?= $class ?>">
            <div class="container">
                <div>
                    <div>
                        Technology, Sofware Development, and Consulting for Websites
                    </div>
                </div>
                <div>
                    <div>
                        Mattifesto<br>
                        14150 NE 20th Street<br>
                        F1-452<br>
                        Bellevue, WA 98007<br>
                        <a href="mailto:matt@mattifesto.com">matt@mattifesto.com</a>
                    </div>
                </div>
            </div>
            <div class="copyright">Copyright &copy; <?= gmdate('Y'), ' ', CBSiteNameHTML ?></div>
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
