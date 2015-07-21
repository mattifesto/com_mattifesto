<?php

final class MDFlexContainerView {

    /**
     * @return {string}
     */
    public static function alignItemsToFlexAlign($flexAlignItems) {
        $translation = [
            'flex-start'    => 'start',
            'flex-end'      => 'end',
            'center'        => 'center',
            'stretch'       => 'stretch',
            'baseline'      => 'baseline'
        ];

        return $translation[$flexAlignItems];
    }

    /**
     * @return [{string}]
     */
    public static function editorURLsForCSS() {
        return [
            CBSystemURL . '/javascript/CBImageEditorFactory.css',
            MDFlexContainerView::URL('MDFlexContainerViewEditor.css')
        ];
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
     * @return {string}
     */
    public static function justifyContentToFlexPack($flexJustifyContent) {
        $translation = [
            'flex-start'    => 'start',
            'flex-end'      => 'end',
            'center'        => 'center',
            'space-around'  => 'justify',
            'space-between' => 'justify'
        ];

        return $translation[$flexJustifyContent];
    }

    /**
     * @return null
     */
    public static function renderModelAsHTML(stdClass $model) {
        $styles = [];

        if ($model->backgroundColor !== null) {
            $styles[] = "background-color: {$model->backgroundColor};";
        }

        $styles[]   = "background-position: {$model->backgroundPositionX} {$model->backgroundPositionY};";

        if ($model->width !== null) {
            $styles[] = "width: {$model->width}px;";
        }

        if ($model->height !== null) {
            $styles[] = "height: {$model->height}px;";
        }

        if (!empty($model->imageURL)) {
            $styles[] = "background-image: url({$model->imageURL});";
        }

        $flexAlign  = MDFlexContainerView::alignItemsToFlexAlign($model->flexAlignItems);
        $styles[]   = "align-items: {$model->flexAlignItems};";
        $styles[]   = "-ms-flex-align: {$flexAlign};";
        $styles[]   = "-webkit-align-items: {$model->flexAlignItems};";

        $styles[]   = "flex-direction: {$model->flexDirection};";
        $styles[]   = "-ms-flex-direction: {$model->flexDirection};";
        $styles[]   = "-webkit-flex-direction: {$model->flexDirection};";

        $flexPack   = MDFlexContainerView::justifyContentToFlexPack($model->flexJustifyContent);
        $styles[]   = "justify-content: {$model->flexJustifyContent};";
        $styles[]   = "-ms-flex-pack: {$flexPack};";
        $styles[]   = "-webkit-justify-content: {$model->flexJustifyContent};";

        $styles     = implode(' ', $styles);

        CBHTMLOutput::addCSSURL(MDFlexContainerView::URL('MDFlexContainerView.css'));

        echo "<{$model->type} class=\"MDFlexContainerView\" style=\"{$styles}\">";

        array_walk($model->subviews, 'CBView::renderModelAsHTML');

        echo "</{$model->type}>";
    }

    /**
     * @return {stdClass}
     */
    public static function specToModel(stdClass $spec) {
        $model                  = CBModels::modelWithClassName(__CLASS__);
        $model->backgroundColor = isset($spec->backgroundColor) ?
                                  MDFlexContainerView::textToCSSValue($spec->backgroundColor) : null;
        $model->height          = isset($spec->height) ? MDFlexContainerView::valueToPixelExtent($spec->height) : null;
        $model->imageURL        = isset($spec->imageURL) ? MDFlexContainerView::URLToCSS($spec->imageURL) : '';
        $model->subviews        = isset($spec->subviews) ? array_map('CBView::specToModel', $spec->subviews) : [];
        $model->width           = isset($spec->width) ? MDFlexContainerView::valueToPixelExtent($spec->width) : null;
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

        $backgroundPositionX    = isset($spec->backgroundPositionX) ? trim($spec->backgroundPositionX) : '';

        switch ($backgroundPositionX) {
            case 'left':
            case 'right':
                $model->backgroundPositionX = $backgroundPositionX;
                break;
            default:
                $model->backgroundPositionX = 'center';
        }

        $backgroundPositionY    = isset($spec->backgroundPositionY) ? trim($spec->backgroundPositionY) : '';

        switch ($backgroundPositionY) {
            case 'top':
            case 'bottom':
                $model->backgroundPositionY = $backgroundPositionY;
                break;
            default:
                $model->backgroundPositionY = 'center';
        }

        $flexAlignItems         = isset($spec->flexAlignItems) ? trim($spec->flexAlignItems) : '';

        switch ($flexAlignItems) {
            case 'flex-start':
            case 'flex-end':
            case 'center':
            case 'baseline':
                $model->flexAlignItems = $flexAlignItems;
                break;
            default:
                $model->flexAlignItems = 'stretch';
        }

        $flexDirection          = isset($spec->flexDirection) ? trim($spec->flexDirection) : '';

        switch ($flexDirection) {
            case 'row-reverse':
            case 'column':
            case 'column-reverse':
                $model->flexDirection = $flexDirection;
                break;
            default:
                $model->flexDirection = 'row';
        }

        $flexJustifyContent     = isset($spec->flexJustifyContent) ? trim($spec->flexJustifyContent) : '';

        switch ($flexJustifyContent) {
            case 'flex-end':
            case 'center':
            case 'space-between':
            case 'space-around':
                $model->flexJustifyContent = $flexJustifyContent;
                break;
            default:
                $model->flexJustifyContent = 'flex-start';
        }

        return $model;
    }

    /**
     * @return {string} | null
     */
    public static function textToCSSValue($text) {
        $value = trim(str_replace(['<', '>', '"', '\'', ';'], '', $text));
        return empty($value) ? null : $value;
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

    /**
     * @return {int}|{float}|null
     */
    public static function valueToPixelExtent($value) {
        if (is_numeric($value)) {
            $number = $value + 0;
            if ($number > 0) {
                return $number;
            }
        }

        return null;
    }
}
