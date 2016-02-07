<?php

final class MDBodyTextView {

    /**
     * @return [{string}]
     */
    public static function editorURLsForCSS() {
        $className = __CLASS__;

        return [ self::URL("{$className}Editor.css") ];
    }

    /**
     * @return [{string}]
     */
    public static function editorURLsForJavaScript() {
        $className = __CLASS__;

        return [
            CBSystemURL . '/javascript/CBResponsiveEditorFactory.js',
            self::URL("{$className}EditorFactory.js")
        ];
    }

    /**
     * @return null
     */
    public static function renderModelAsHTML(stdClass $model) {
        $className = __CLASS__;

        CBHTMLOutput::addCSSURL(self::URL("{$className}.css"));

        ?>

        <section class="<?= $className ?>">
            <h1 class="MDH1Text"><?= $model->titleAsHTML ?></h1>
            <div class="MDBodyText"><?= $model->contentAsHTML ?></div>
        </section>

        <?php
    }

    /**
     * @return {stdClass}
     */
    public static function specToModel(stdClass $spec) {
        $model = CBModels::modelWithClassName(__CLASS__);
        $model->contentAsMarkaround = isset($spec->contentAsMarkaround) ? $spec->contentAsMarkaround : '';
        $model->contentAsHTML = CBMarkaround::markaroundToHTML($model->contentAsMarkaround);
        $model->title = isset($spec->title) ? trim($spec->title) : '';
        $model->titleAsHTML = ColbyConvert::textToHTML($model->title);

        return $model;
    }

    /**
     * @return {string}
     */
    public static function URL($filename) {
        $className = __CLASS__;

        return CBSiteURL . "/classes/{$className}/{$filename}";
    }
}
