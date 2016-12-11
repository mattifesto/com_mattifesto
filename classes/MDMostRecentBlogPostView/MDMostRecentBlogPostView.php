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

            $publishedAsHTML = ColbyConvert::timestampToHTML($summary->publicationTimeStamp, 'Unpublished');

            if (empty($model->useLightTextColors)) {
                $class = '';
            } else {
                $class = 'light';
            }

            ?>

            <a class="MDMostRecentBlogPostView <?= $class ?>" href="/<?= $summary->URI ?>/">
                <div>
                    <div class="header">
                        <div>Newest Blog Post</div>
                        <div><?= $publishedAsHTML ?></div>
                    </div>

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
                    <div class="description"><?= $summary->descriptionHTML ?></div>
                    <div><span class="link">read more &gt;</span></div>
                </div>
            </a>

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
            'useLightTextColors' => CBModel::value($spec, 'useLightTextColors', false, 'boolval'),
        ];
    }
}
