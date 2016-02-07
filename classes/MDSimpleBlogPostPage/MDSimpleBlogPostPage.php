<?php

final class MDSimpleBlogPostPage {
    const schemaVersion = 1;

    /**
     * @return stdClass
     */
    public static function info() {
        return CBModelClassInfo::specToModel((object)[
            'pluralTitle' => 'Simple Blog Post Pages',
            'singularTitle' => 'Simple Blog Post Page',
        ]);
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
        $preferences = CBModelCache::fetchModelByID(MDSimpleBlogPostPagePreferences::ID);
        $containerThemeID = CBModel::value($model, 'containerThemeID', $preferences->defaultContainerThemeID);
        $contentThemeID = CBModel::value($model, 'contentThemeID', $preferences->defaultContentThemeID);
        $headerThemeID = CBModel::value($model, 'headerThemeID', $preferences->defaultHeaderThemeID);
        $menuThemeID = CBModel::value($model, 'menuThemeID', $preferences->defaultMenuThemeID);

        CBHTMLOutput::begin();
        CBHTMLOutput::$classNameForSettings = 'MDPageSettingsForResponsivePages';
        CBHTMLOutput::addCSSURL(CBTheme::IDToCSSURL($containerThemeID));
        CBHTMLOutput::addCSSURL(CBTheme::IDToCSSURL($headerThemeID));
        CBHTMLOutput::setTitleHTML($model->titleAsHTML);

        $containerThemeClass = CBTheme::IDToCSSClass($containerThemeID);
        $headerThemeClass = CBTheme::IDToCSSClass($headerThemeID); ?>

        <div class="MDSimpleBlogPostPage <?= $containerThemeClass ?>"> <?php

            CBThemedMenuView::renderModelAsHTML((object)[
                'menuID' => CBMainMenu::ID,
                'selectedItemName' => 'blog',
                'themeID' => $menuThemeID,
            ]); ?>

            <article>
                <header class="CBHeaderTextView <?= $headerThemeClass ?>">
                    <h1><?= $model->titleAsHTML ?></h1>
                    <div><?= $model->descriptionAsHTML ?></div>
                    <?= ColbyConvert::timestampToHTML($model->published) ?>
                </header> <?php

                CBThemedTextView::renderModelAsHTML((object)[
                    'contentAsHTML' => $model->contentAsHTML,
                    'themeID' => $contentThemeID,
                ]); ?>

            </article>
        </div> <?php

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
        $model->containerThemeID = CBModel::value($spec, 'containerThemeID');
        $model->contentAsHTML = CBMarkaround::markaroundToHTML(CBModel::value($spec, 'contentAsMarkaround'));
        $model->contentThemeID = CBModel::value($spec, 'contentThemeID');
        $model->headerThemeID = CBModel::value($spec, 'headerThemeID');
        $model->menuThemeID = CBModel::value($spec, 'menuThemeID');
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
