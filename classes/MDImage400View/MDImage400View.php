<?php

final class MDImage400View {

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
        $styles = [];

        CBHTMLOutput::addCSSURL(self::URL("{$className}.css"));

        if (isset($model->image)) {
            $URL = CBDataStore::toURL([
                'ID' => $model->image->ID,
                'filename' => "original.{$model->image->extension}"
            ]);

            $styles[] = "background-image: url({$URL});";
        }

        $styles = implode(' ', $styles);

        ?>

        <section class="<?= $className ?>" style="<?= $styles ?>">
        </section>

        <?php
    }

    /**
     * @return {stdClass}
     */
    public static function specToModel(stdClass $spec) {
        $model = CBModels::modelWithClassName(__CLASS__);

        if (isset($spec->image->extension) && isset($spec->image->ID)) {
            $model->image = new stdClass();
            $model->image->extension = $spec->image->extension;
            $model->image->ID = $spec->image->ID;
        }

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
