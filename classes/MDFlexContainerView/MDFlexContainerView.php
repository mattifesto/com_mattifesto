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
     * @return null
     */
    public static function renderModelAsHTML(stdClass $model) {
        echo "<{$model->type} class=\"MDFlexContainerView\">";

        array_walk($model->subviews, 'CBView::renderModelAsHTML');

        echo "</{$model->type}>";
    }

    /**
     * @return {stdClass}
     */
    public static function specToModel(stdClass $spec) {
        $model              = CBModels::modelWithClassName(__CLASS__);
        $model->subviews    = isset($spec->subviews) ? array_map('CBView::specToModel', $spec->subviews) : [];
        $type               = isset($spec->type) ? trim($spec->type) : "";

        switch ($type) {
            case "article":
                $model->type = "article";
                break;
            case "main":
                $model->type = "main";
                break;
            default:
                $model->type = "div";
        }

        return $model;
    }

    /**
     * @return {string}
     */
    public static function URL($filename) {
        return CBSiteURL . "/classes/MDFlexContainerView/{$filename}";
    }
}
