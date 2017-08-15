<?php

final class MDMostRecentBlogPostViewEditor {

    /**
     * @return [string]
     */
    static function requiredClassNames() {
        return ['CBUI'];
    }

    /**
     * @return [string]
     */
    static function requiredJavaScriptURLs() {
        return [Colby::flexpath(__CLASS__, 'js', cbsiteurl())];
    }
}
