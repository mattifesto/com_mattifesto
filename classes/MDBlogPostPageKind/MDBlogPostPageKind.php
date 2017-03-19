<?php

final class MDBlogPostPageKind {

    /**
     * @param [stdClass] $args->archives
     * @param [stdClass] $args->pageSummaries
     * @param string $args->title
     *
     * @return null
     */
    static function renderIndexForCBPageListView($args) {
        CBHTMLOutput::addCSSURL(Colby::flexnameForCSSForClass(CBSitePreferences::siteURL(), __CLASS__));

        ?>

        <div class="MDBlogPostPageKindIndex">
            <h1><?= $args->title ?></h1>

            <div class="posts">
                <?php

                array_walk($args->pageSummaries, function ($summary) {
                    $imageClass = '';

                    // 2016.12.03 TODO: This operation should be a function on CBImages.
                    if (preg_match('%/data/([0-9a-f]{2})/([0-9a-f]{2})/([0-9a-f]{36})/([^/]+)$%', $summary->thumbnailURL, $matches)) {
                        $ID = "{$matches[1]}{$matches[2]}{$matches[3]}";
                        $basename = $matches[4];
                        $pathinfo = pathinfo($basename);
                        $extension = $pathinfo['extension'];
                        $imageSrc = CBDataStore::flexpath($ID, "rw640.{$extension}", CBSitePreferences::siteURL());
                    } else {
                        $imageSrc = $summary->thumbnailURL;

                        if (empty($imageSrc)) {
                            $imageClass = 'empty';
                        }
                    }

                    ?>

                    <a href="<?= "/{$summary->URI}/"?>" class="post">
                        <div class="image">
                            <div class="<?= $imageClass ?>">
                                <?php if (!empty($imageSrc)) { ?>
                                    <img src="<?= $imageSrc ?>" alt="<?= $summary->titleHTML ?>">
                                <?php } ?>
                            </div>
                        </div>
                        <h2><?= $summary->titleHTML ?></h2>
                        <div class="description"><?= $summary->subtitleHTML ?></div>
                    </a>

                    <?php
                });

                ?>
            </div>

            <div class="archives">
                <?php

                $links = array_map(function ($archive) {
                    return "<a href=\"{$archive->URI}\">{$archive->title}</a>";
                }, $args->archives);

                echo implode(' | ', $links);

                ?>
            </div>
        </div>

        <?php
    }
}
