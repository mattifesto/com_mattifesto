<?php

final class MDSimpleBlogPostPage {

    const schemaVersion = 1;

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
        CBHTMLOutput::begin();
        CBHTMLOutput::$classNameForSettings = 'MDPageSettingsForResponsivePages';
        CBHTMLOutput::addCSSURL(MDSimpleBlogPostPage::URL('MDSimpleBlogPostPage.css'));
        CBHTMLOutput::setTitleHTML($model->titleAsHTML);

        ?>

        <article class="MDSimpleBlogPost">
            <header>
                <h1><?= $model->titleAsHTML ?></h1>
                <div><?= $model->descriptionAsHTML ?></div>
                <?= ColbyConvert::timestampToHTML($model->published) ?>
            </header>
            <section>
                <?= $model->bodyAsHTML ?>
            </section>
        </article>

        <?php

        CBHTMLOutput::render();
    }

    /**
     * @param stdClass $spec
     *
     * @return stdClass
     */
    public static function specToModel(stdClass $spec) {
        $spec = clone $spec;
        $spec->classNameForKind = 'MDBlogPost';
        $model = CBPages::specToModel($spec);
        $model->bodyAsHTML = ColbyConvert::markaroundToHTML(CBModel::value($spec, 'bodyAsMarkaround', ''));

        $model->schemaVersion = MDSimpleBlogPostPage::schemaVersion;

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
