<?php

final class MDFloatingHeaderView {

    /**
     * @return [{string}]
     */
    public static function editorURLsForCSS() {
        return [ MDFloatingHeaderView::URL('MDFloatingHeaderViewEditor.css') ];
    }

    /**
     * @return [{string}]
     */
    public static function editorURLsForJavaScript() {
        return [
            CBSystemURL . '/javascript/CBStringEditorFactory.js',
            MDFloatingHeaderView::URL('MDFloatingHeaderViewEditorFactory.js')
        ];
    }

    /**
     * @return {stdClass}
     */
    public static function fetchMenuForAjax() {
        $response                   = new CBAjaxResponse();
        $response->menu             = CBModels::fetchModelByID(CBMainMenu::ID);
        $response->wasSuccessful    = true;
        $response->send();
    }

    /**
     * @return {stdClass}
     */
    public static function fetchMenuForAjaxPermissions() {
        return (object)['group' => 'Administrators'];
    }

    /**
     * @return [<hex160>]
     */
    public static function modelToModelDependencies(stdClass $model) {
        return [CBMainMenu::ID];
    }

    /**
     * @return null
     */
    public static function renderModelAsHTML(stdClass $model) {
        CBHTMLOutput::addCSSURL(MDFloatingHeaderView::URL('MDFloatingHeaderView.css'));

        $menu = CBModelCache::fetchModelByID(CBMainMenu::ID);

        echo '<header class="MDFloatingHeaderView"><ul>';

        array_walk($menu->items, function($item) use ($model) {
            if ($model->selectedMenuItemName === $item->name) {
                $class = 'class="selected"';
            } else {
                $class = '';
            }

            if ($model->colorAsHTML) {
                $style = "style=\"color: {$model->colorAsHTML}\"";
            } else {
                $style = '';
            }

            echo "<li {$class}><a href=\"{$item->URLAsHTML}\" {$style}>{$item->textAsHTML}</a></li>";
        });

        echo '</ul></header>';
    }

    /**
     * @return {stdClass}
     */
    public static function specToModel(stdClass $spec) {
        $model                          = CBModels::modelWithClassName(__CLASS__);
        $model->color                   = isset($spec->color) ? trim($spec->color) : '';
        $model->colorAsHTML             = ColbyConvert::textToHTML($model->color);
        $model->selectedMenuItemName    = isset($spec->selectedMenuItemName) ? trim($spec->selectedMenuItemName) : '';

        return $model;
    }

    /**
     * @return string
     */
    public static function URL($filename) {
        return CBSiteURL . "/classes/MDFloatingHeaderView/{$filename}";
    }
}
