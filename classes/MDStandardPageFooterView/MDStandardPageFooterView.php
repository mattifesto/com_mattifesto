<?php

final class MDStandardPageFooterView {

    /**
     * @param bool? $model->hideFlexboxFill
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

        if (empty(CBModel::value($model, 'hideFlexboxFill'))) {
            echo '<div class="MDStandardPageFooterViewFill" style="flex: 1 1 auto;"></div>';
        }

        $sitePreferences = CBSitePreferences::model();

        ?>

        <footer class="MDStandardPageFooterView <?= $class ?>">
            <div class="container">
                <div>
                    <div>
                        Technology, Software Development, and Consulting for Websites
                    </div>
                </div>
                <div>
                    <ul>
                        <?php

                        if (!empty($URL = $sitePreferences->facebookURL)) {
                            echo "<li><a href=\"{$URL}\">Facebook</a></li>";
                        }

                        if (!empty($URL = $sitePreferences->twitterURL)) {
                            echo "<li><a href=\"{$URL}\">Twitter</a></li>";
                        }

                        ?>
                    </ul>
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
            <div class="copyright">Copyright &copy; <?= gmdate('Y') ?> Mattifesto Design</div>
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
