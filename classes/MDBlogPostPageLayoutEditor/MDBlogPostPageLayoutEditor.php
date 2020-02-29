<?php

final class MDBlogPostPageLayoutEditor {

    /* -- CBHTMLOutput interfaces -- -- -- -- -- */



    /**
     * @return [string]
     */
    static function CBHTMLOutput_JavaScriptURLs() {
        return [
            Colby::flexpath(__CLASS__, 'v137.js', cbsiteurl()),
        ];
    }



    /**
     * @return [string]
     */
    static function CBHTMLOutput_requiredClassNames(): array {
        return [
            'CBModel',
            'CBUI',
            'CBUIBooleanEditor',
            'CBUIStringEditor',
        ];
    }
    /* CBHTMLOutput_requiredClassNames() */

}
