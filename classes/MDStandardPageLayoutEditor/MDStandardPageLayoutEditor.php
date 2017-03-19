<?php

final class MDStandardPageLayoutEditor {

    /**
     * @return [string]
     */
    public static function requiredClassNames() {
        return ['CBUI', 'CBUIBooleanEditor'];
    }

    /**
     * @return [string]
     */
    public static function requiredJavaScriptURLs() {
        return [MDStandardPageLayoutEditor::URL('MDStandardPageLayoutEditor.js')];
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    public static function URL($filename) {
        $className = __CLASS__;
        return CBSitePreferences::siteURL() . "/classes/{$className}/{$filename}";
    }
}
