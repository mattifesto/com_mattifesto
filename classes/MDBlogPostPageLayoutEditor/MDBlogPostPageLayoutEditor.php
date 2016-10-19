<?php

final class MDBlogPostPageLayoutEditor {

    /**
     * @return [string]
     */
    public static function requiredClassNames() {
        return ['CBUI', 'CBUIBooleanEditor', 'CBUIStringEditor'];
    }

    /**
     * @return [string]
     */
    public static function requiredJavaScriptURLs() {
        return [Colby::URLForJavaScriptForSiteClass(__CLASS__)];
    }
}
