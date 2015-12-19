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
        $model->bodyAsHTML = ColbyConvert::markaroundToHTML(CBModel::value($spec, 'bodyAsMarkaround', ''));

        $model->schemaVersion = MDSimpleBlogPostPage::schemaVersion;

        return $model;
    }
}
