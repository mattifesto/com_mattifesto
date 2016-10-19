<?php

/**
 * Mattifesto implementation
 */
class CBViewPageTemplates {

    /**
     * @return [string]
     *  The list of page templates available to the page editor.
     */
    public static function availableTemplateClassNames() {
        return ['CBPageTemplate', 'MDBlogPostPageTemplate'];
    }
}
