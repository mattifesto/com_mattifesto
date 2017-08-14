<?php

final class MDStandardPageFooterView {

    /**
     * @return [string]
     */
    static function CBHTMLOutput_CSSURLs() {
        return [Colby::flexpath(__CLASS__, 'css', cbsiteurl())];
    }

    /**
     * @param bool? $model->hideFlexboxFill
     * @param hex160? $model->themeID
     *
     * @return null
     */
    static function CBView_render(stdClass $model = null) {
        $year = gmdate('Y');

        if (empty(CBModel::value($model, 'hideFlexboxFill'))) {
            echo '<div class="MDStandardPageFooterViewFill" style="flex: 1 1 auto;"></div>';
        }

        $sitePreferences = CBSitePreferences::model();

        ?>

        <footer class="MDStandardPageFooterView CBDarkTheme">
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
    static function CBModel_toModel(stdClass $spec) {
        return (object)[
            'className' => __CLASS__,
            'themeID' => CBModel::value($spec, 'themeID'),
        ];
    }
}
