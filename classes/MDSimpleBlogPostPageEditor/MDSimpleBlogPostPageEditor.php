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
        return MDSimpleBlogPostPagePreferencesEditor::requiredJavaScriptVariables();
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
