<?php

final class MDFlexContainerView {

    /**
     * @return [{string}]
     */
    public static function editorURLsForCSS() {
        return [ MDFlexContainerView::URL('MDFlexContainerViewEditor.css') ];
    }

    /**
     * @return [{string}]
     */
    public static function editorURLsForJavaScript() {
        return [
            CBSystemURL . '/javascript/CBImageEditorFactory.js',
            CBSystemURL . '/javascript/CBStringEditorFactory.js',
            MDFlexContainerView::URL('MDFlexContainerViewEditorFactory.js')
        ];
    }

    /**
     * @return {stdClass}
     */
    public static function specToModel(stdClass $spec) {
        $model  = CBModels::modelWithClassName(__CLASS__);

        return $model;
    }

    /**
     * @return {string}
     */
    public static function URL($filename) {
        return CBSiteURL . "/classes/MDFlexContainerView/{$filename}";
    }
}
