<?php

final class MDBlogPostLibraryPage {

    const ID = 'e6dfbf5797e468a74429dbc837631a1e99e7c7a7';
    const schemaVersion = 1;

    public static function install() {
        $spec = CBModels::fetchSpecByID(MDBlogPostLibraryPage::ID);

        if ($spec === false) {
            $spec = CBModels::modelWithClassName(__CLASS__, ['ID' => MDBlogPostLibraryPage::ID]);
            $spec->description = 'The Mattifesto Blog';
            $spec->published = time();
            $spec->title = 'Blog';
            $spec->URIPath = 'blog';
            $spec->schemaVersion = MDBlogPostLibraryPage::schemaVersion;
            CBModels::save([$spec]);
        } else if (!isset($spec->schemaVersion) || $spec->schemaVersion < MDBlogPostLibraryPage::schemaVersion) {
            $spec = CBModels::fetchSpecByID(MDBlogPostLibraryPage::ID);
            $spec->schemaVersion = MDBlogPostLibraryPage::schemaVersion;
            CBModels::save([$spec]);
        }
    }

    /**
     * @param [stdClass] $tuples
     *
     * @return null
     */
    public static function modelsWillSave(array $tuples) {
        $models = array_map(function($tuple) { return $tuple->model; }, $tuples);
        CBPages::save($models);
    }

    /**
     * @param [hex160] $IDs
     *
     * @return null
     */
    public static function modelsWillDelete(array $IDs) {
        CBPages::deletePagesByID($IDs);
    }

    /**
     * @param stdClass $model
     *
     * @return string
     */
    public static function modelToSearchText(stdClass $model) {
        return "{$model->title} {$model->description}";
    }

    /**
     * @param stdClass $model
     *
     * @return null
     */
    public static function renderModelAsHTML(stdClass $model) {
        CBHTMLOutput::$classNameForSettings = 'MDPageSettingsForResponsivePages';
        CBHTMLOutput::setTitleHTML($model->titleAsHTML);
        CBHTMLOutput::addCSSURL(MDBlogPostLibraryPage::URL('MDBlogPostLibraryPage.css'));
        CBHTMLOutput::begin();

        $SQL = <<<EOT

            SELECT `keyValueData`
            FROM `ColbyPages`
            WHERE `classNameForKind` = 'MDBlogPost' AND `published` IS NOT NULL
            ORDER BY `published` DESC
            LIMIT 20

EOT;

        $modelsForPages = CBDB::SQLToArray($SQL, ['valueIsJSON' => true]);

        echo "<h1 style=\"padding: 50px; text-align: center;\">{$model->titleAsHTML}</h1>";

        foreach ($modelsForPages as $modelForPage) { ?>
            <a class="MDBlogPostSummary" href="<?= CBSiteURL, '/', $modelForPage->URI, '/' ?>">
                <article>
                    <div class="published">
                        <?= ColbyConvert::timestampToHTML($modelForPage->publicationTimeStamp) ?>
                    </div>
                    <h1><?= $modelForPage->titleHTML ?></h1>
                    <div class="description">
                        <?= $modelForPage->descriptionHTML ?>
                    </div>

                </article>
            </a>
        <?php }


        CBHTMLOutput::render();
    }

    /**
     * @param stdClass $spec
     *
     * @return stdClass
     */
    public static function specToModel(stdClass $spec) {
        $model = CBPages::specToModel($spec);
        $model->schemaVersion = MDBlogPostLibraryPage::schemaVersion;

        return $model;
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public static function URL($filename) {
        $className = __CLASS__;
        return CBSiteURL . "/classes/{$className}/{$filename}";
    }
}
