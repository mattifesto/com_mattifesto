<?php

final class MDSimpleBlogPostPagePreferencesEditor {

    /**
     * @param [stdClass] $themes
     * @param string $classNameForKind
     *
     * @return [stdClass]
     */
    public static function filterThemes($themes, $classNameForKind) {
        $filteredThemes = array_filter($themes, function ($theme) use ($classNameForKind) {
            return $theme->classNameForKind === $classNameForKind;
        });

        return array_values(array_map(function ($theme) {
            return (object)[
                'title' => $theme->title,
                'description' => $theme->description,
                'value' => $theme->ID,
            ];
        }, $filteredThemes));
    }

    /**
     * @return [string]
     */
    public static function requiredClassNames() {
        return ['CBUI', 'CBUISelector'];
    }

    /**
     * @return [string]
     */
    public static function requiredJavaScriptURLs() {
        return [MDSimpleBlogPostPagePreferencesEditor::URL('MDSimpleBlogPostPagePreferencesEditor.js')];
    }

    /**
     * @return [[string (name), mixed (value)]]
     */
    public static function requiredJavaScriptVariables() {
        $SQL = <<<EOT

            SELECT  `v`.`modelAsJSON`
            FROM    `CBModels` AS `m`
            JOIN    `CBModelVersions` AS `v` ON `m`.`ID` = `v`.`ID` AND `m`.`version` = `v`.`version`
            WHERE   `m`.`className` = 'CBTheme'

EOT;

        $themes = CBDB::SQLToArray($SQL, ['valueIsJSON' => true]);
        $containerViewThemes = MDSimpleBlogPostPagePreferencesEditor::filterThemes($themes, "CBContainerView");
        $headerTextViewThemes = MDSimpleBlogPostPagePreferencesEditor::filterThemes($themes, "CBHeaderTextView");
        $menuViewThemes = MDSimpleBlogPostPagePreferencesEditor::filterThemes($themes, "CBMenuView");
        $textViewThemes = MDSimpleBlogPostPagePreferencesEditor::filterThemes($themes, "CBTextView");

        return [
            ['CBContainerViewThemes', array_values($containerViewThemes)],
            ['CBMenuViewThemes', array_values($menuViewThemes)],
            ['CBTextViewThemes', array_values($textViewThemes)],
            ['CBHeaderTextViewThemes', array_values($headerTextViewThemes)],
        ];
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
