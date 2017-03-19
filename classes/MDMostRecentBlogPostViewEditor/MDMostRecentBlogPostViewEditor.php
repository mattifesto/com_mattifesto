<?php

final class MDMostRecentBlogPostViewEditor {

    /**
     * @return [string]
     */
    static function requiredClassNames() {
        return ['CBUI', 'CBUIBooleanEditor'];
    }

    /**
     * @return [string]
     */
    static function requiredJavaScriptURLs() {
        return [Colby::flexnameForJavaScriptForClass(CBSitePreferences::siteURL(), __CLASS__)];
    }
}
