<?php

final class MDSimpleBlogPostPageEditor {

    /**
     * @return [string]
     */
    public static function requiredClassNames() {
        return ['CBUI', 'CBUISelector', 'CBUIStringEditor', 'CBUISuggestedStringEditor', 'CBUIUnixTimestampEditor'];
    }

    /**
     * @return [string]
     */
    public static function requiredCSSURLs() {
        return [MDSimpleBlogPostPageEditor::URL('MDSimpleBlogPostPageEditor.css')];
    }

    /**
     * @return [string]
     */
    public static function requiredJavaScriptURLs() {
        return [MDSimpleBlogPostPageEditor::URL('MDSimpleBlogPostPageEditorFactory.js')];
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

        $pageThemes = array_filter($themes, function ($theme) {
            return $theme->classNameForKind === "MDContainer";
        });

        $pageThemes = array_map(function ($theme) {
            return (object)[
                'title' => $theme->title,
                'description' => $theme->description,
                'value' => $theme->ID,
            ];
        }, $pageThemes);

        return [['MDSimpleBlogPostPageThemes', array_values($pageThemes)]];
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
