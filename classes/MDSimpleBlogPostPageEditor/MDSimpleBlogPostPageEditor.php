<?php

final class MDSimpleBlogPostPageEditor {

    /**
     * @return [string]
     */
    public static function requiredClassNames() {
        return ['CBUI', 'CBUIStringEditor', 'CBUIUnixTimestampEditor'];
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
     * @param string $filename
     *
     * @return string
     */
    public static function URL($filename) {
        $className = __CLASS__;
        return CBSiteURL . "/classes/{$className}/{$filename}";
    }
}
