<?php

final class MDMostRecentBlogPostView {

    /**
     * @return stdClass
     */
    private static function fetchSummary() {
        $SQL = <<<EOT

            SELECT `keyValueData`
            FROM `ColbyPages`
            WHERE `classNameForKind` = 'MDBlogPostPageKind'
            AND `published` IS NOT NULL
            ORDER BY `published` DESC
            LIMIT 1

EOT;

        return CBDB::SQLToValue($SQL, ['valueIsJSON' => true]);
    }

    /**
     * @param stdClass $model
     *
     * @return null
     */
    static function renderModelAsHTML(stdClass $model) {
        if ($summary = MDMostRecentBlogPostView::fetchSummary()) {
            CBHTMLOutput::requireClassName(__CLASS__);

            ?>

            <div class="MDMostRecentBlogPostView">
                <div>
                    <?php

                    if (!empty($summary->image)) {
                        $image = $summary->image;
                        $imageURL = CBDataStore::flexpath($image->ID, "rw1280.{$image->extension}", CBSiteURL);

                        ?>

                        <div class="image">
                            <div>
                                <img src="<?= $imageURL ?>" alt="<?= $summary->titleHTML ?>">
                            </div>
                        </div>

                        <?php
                    }

                    ?>
                    <h2><?= $summary->titleHTML ?></h2>
                    <div><?= $summary->descriptionHTML ?></div>
                    <div><a href="/<?= $summary->URI ?>/">read more &gt;</a></div>
                </div>
            </div>

            <?php
        }
    }

    /**
     * @return [string]
     */
    static function requiredCSSURLs() {
        return [Colby::flexnameForCSSForClass(CBSiteURL, __CLASS__)];
    }

    /**
     * @param stdClass $spec
     *
     * @return stdClass
     */
    static function specToModel(stdClass $spec) {
        return (object)[
            'className' => __CLASS__,
        ];
    }
}
