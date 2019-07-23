<?php

final class MDStandardPageFooterView {

    /**
     * @return [string]
     */
    static function CBHTMLOutput_CSSURLs(): array {
        return [
            Colby::flexpath(__CLASS__, 'v108.css', cbsiteurl()),
        ];
    }


    /**
     * @param object $model
     *
     * @return void
     */
    static function CBView_render(stdClass $model): void {
        $year = gmdate('Y');

        $sitePreferences = CBSitePreferences::model();

        ?>

        <footer class="MDStandardPageFooterView CBDarkTheme">
            <div class="container">
                <div>
                    <div>
                        Technology, Software Development, and Consulting for
                        Websites
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
                        <a href="mailto:matt@mattifesto.com"><?=
                            'matt@mattifesto.com'
                        ?></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                Copyright &copy; <?= gmdate('Y') ?>
                Mattifesto Design
            </div>
        </footer>

        <?php
    }


    /**
     * @param object $spec
     *
     * @return object
     */
    static function CBModel_build(stdClass $spec): stdClass {
        return (object)[
            'themeID' => CBModel::value($spec, 'themeID'),
        ];
    }
    /* CBModel_build() */
}
