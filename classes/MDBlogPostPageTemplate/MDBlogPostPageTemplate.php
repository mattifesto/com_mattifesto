<?php

final class MDBlogPostPageTemplate {

    /**
     * @return stdClass
     */
    public static function model() {
        $spec = (object)[
            'className' => 'CBViewPage',
            'classNameForKind' => 'MDBlogPostPageKind',
            'layout' => (object)['className' => 'MDBlogPostPageLayout'],
        ];

        // text
        $spec->sections[] = (object)[
            'className' => 'CBTextView2',
        ];

        return $spec;
    }

    /**
     * @return string
     */
    public static function title() {
        return 'Blog Post';
    }
}
