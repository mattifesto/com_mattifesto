<?php

final class MDBlogPostPageTemplate {

    /**
     * @return object
     */
    static function CBModelTemplate_spec() {
        $spec = (object)[
            'className' => 'CBViewPage',
            'classNameForKind' => 'MDBlogPostPageKind',
            'layout' => (object)[
                'className' => 'CBPageLayout',
                'CSSClassNames' => 'endContentWithWhiteSpace',
                'customLayoutClassName' => 'MDBlogPostPageLayout',
                'isArticle' => true,
            ],
        ];

        $spec->sections[] = (object)[
            'className' => 'CBPageTitleAndDescriptionView',
            'showPublicationDate' => true,
        ];

        $spec->sections[] = (object)[
            'className' => 'CBArtworkView',
        ];

        // text
        $spec->sections[] = (object)[
            'className' => 'CBMessageView',
        ];

        return $spec;
    }

    /**
     * @return string
     */
    static function CBModelTemplate_title() {
        return 'Mattifesto Blog Post';
    }
}
