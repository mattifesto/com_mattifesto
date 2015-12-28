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

        // container view themes

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

        // menu view themes

        $menuViewThemes = array_filter($themes, function ($theme) {
            return $theme->classNameForKind === "CBMenuView";
        });

        $menuViewThemes = array_map(function ($theme) {
            return (object)[
                'title' => $theme->title,
                'description' => $theme->description,
                'value' => $theme->ID,
            ];
        }, $menuViewThemes);

        // text view themes

        $textViewThemes = array_filter($themes, function ($theme) {
            return $theme->classNameForKind === "CBTextView";
        });

        $textViewThemes = array_map(function ($theme) {
            return (object)[
                'title' => $theme->title,
                'description' => $theme->description,
                'value' => $theme->ID,
            ];
        }, $textViewThemes);

        // header text view themes

        $headerTextViewThemes = array_filter($themes, function ($theme) {
            return $theme->classNameForKind === "CBHeaderTextView";
        });

        $headerTextViewThemes = array_map(function ($theme) {
            return (object)[
                'title' => $theme->title,
                'description' => $theme->description,
                'value' => $theme->ID,
            ];
        }, $headerTextViewThemes);

        return [
            ['MDSimpleBlogPostPageThemes', array_values($pageThemes)],
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
