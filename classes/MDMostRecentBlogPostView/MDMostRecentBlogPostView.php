<?php

final class MDMostRecentBlogPostView {

    /**
     * @return object
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
     * @param object $model
     *
     * @return null
     */
    static function CBView_render(stdClass $model) {
        if ($summary = MDMostRecentBlogPostView::fetchSummary()) {
            $publishedAsHTML = ColbyConvert::timestampToHTML($summary->publicationTimeStamp, 'Unpublished');

            ?>

            <a class="MDMostRecentBlogPostView" href="/<?= $summary->URI ?>/">
                <?php

                $imageURL = CBImage::valueToFlexpath($summary, 'image', 'rw1280', cbsiteurl());

                if ($imageURL !== false) {
                    $image = $summary->image;

                    CBArtworkElement::render([
                        'height' => $image->height,
                        'maxWidth' => 640,
                        'URL' => $imageURL,
                        'width' => $image->width,
                    ]);
                }

                ?>

                <h2><?= cbhtml($summary->title); ?></h2>
                <div class="description"><?= cbhtml($summary->description) ?></div>
                <div><span class="link">read more &gt;</span></div>
            </a>

            <?php
        }
    }

    /**
     * @return [string]
     */
    static function CBHTMLOutput_CSSURLs() {
        return [Colby::flexpath(__CLASS__, 'css', cbsiteurl())];
    }

    /**
     * @param stdClass $spec
     *
     * @return stdClass
     */
    static function CBModel_toModel(stdClass $spec) {
        return (object)[
            'className' => __CLASS__,
        ];
    }
}
