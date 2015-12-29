<?php

final class MDSimpleBlogPostPagePreferences {
    const ID = '41810c84be7f5b20d4120ad27e07192085fbc346';
    const schemaVersion = 1;

    /**
     * @return stdClass
     */
    public static function info() {
        return CBModelClassInfo::specToModel((object)[
            'pluralTitle' => 'Simple Blog Post Page Preferences',
            'singularTitle' => 'Simple Blog Post Page Preferences',
        ]);
    }

    public static function install() {
        $spec = CBModels::fetchSpecByID(MDSimpleBlogPostPagePreferences::ID);

        if ($spec === false) {
            $spec = (object)['className' => __CLASS__, 'ID' => MDSimpleBlogPostPagePreferences::ID];
        }

        if (empty($spec->schemaVersion) || $spec->schemaVersion < MDSimpleBlogPostPagePreferences::schemaVersion) {
            $spec->schemaVersion = MDSimpleBlogPostPagePreferences::schemaVersion;
            CBModels::save([$spec]);
        }
    }

    /**
     * @param stdClass $spec
     *
     * @return stdClass
     */
    public static function specToModel(stdClass $spec) {
        $model = (object)['className' => __CLASS__];
        $model->defaultContainerThemeID = CBModel::value($spec, 'defaultContainerThemeID');
        $model->defaultContentThemeID = CBModel::value($spec, 'defaultContentThemeID');
        $model->defaultHeaderThemeID = CBModel::value($spec, 'defaultHeaderThemeID');
        $model->defaultMenuThemeID = CBModel::value($spec, 'defaultMenuThemeID');
        $model->schemaVersion = MDSimpleBlogPostPagePreferences::schemaVersion;
        $model->title = 'MDSimpleBlogPostPage Preferences';

        return $model;
    }
}
