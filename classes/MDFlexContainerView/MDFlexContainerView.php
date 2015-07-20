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
        $styles = [];

        if (!empty($model->imageURL)) {
            $styles[] = "background-image: url({$model->imageURL});";
        }

        $styles = implode(' ', $styles);

        echo "<{$model->type} class=\"MDFlexContainerView\" style=\"{$styles}\">";

        array_walk($model->subviews, 'CBView::renderModelAsHTML');

        echo "</{$model->type}>";
    }

    /**
     * @return {stdClass}
     */
    public static function specToModel(stdClass $spec) {
        $model                  = CBModels::modelWithClassName(__CLASS__);
        $model->imageURL        = isset($spec->imageURL) ? MDFlexContainerView::URLToCSS($spec->imageURL) : '';
        $model->subviews        = isset($spec->subviews) ? array_map('CBView::specToModel', $spec->subviews) : [];
        $type                   = isset($spec->type) ? trim($spec->type) : '';

        switch ($type) {
            case 'article':
                $model->type = 'article';
                break;
            case 'main':
                $model->type = 'main';
                break;
            default:
                $model->type = 'div';
        }

        return $model;
    }

    /**
     * @return {string}
     */
    public static function URL($filename) {
        return CBSiteURL . "/classes/MDFlexContainerView/{$filename}";
    }

    /**
     * This function detects the following characters in a URL:
     *
     *          '  "  <  >  &  (  )
     *
     * If the URL contains one or more of these characters it is considered
     * invalid for the purposes of this view due to the way it will be embedded
     * in the style property of the element and the encertainties on how those
     * characters should or even can be escaped propertly.  Otherise the URL is
     * trimmed and returned.
     *
     * @return {string}
     */
    public static function URLToCSS($URL) {
        if (preg_match('/[\'"<>&()]/', $URL)) {
            return '';
        } else {
            return trim($URL);
        }
    }
}
