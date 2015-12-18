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
        CBHTMLOutput::begin();
        CBHTMLOutput::setTitleHTML($model->titleAsHTML);

        echo "<h1 style=\"padding: 100px; text-align: center;\">{$model->titleAsHTML}</h1>";

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
}
