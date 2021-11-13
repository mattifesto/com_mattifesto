<?php

final class
MDBlogPostPageTemplate {

    /* -- CBInstall interfaces -- -- -- -- -- */



    /**
     * @return void
     */
    static function CBInstall_install(): void {
        CBModelTemplateCatalog::install(__CLASS__);
    }



    /**
     * @return [string]
     */
    static function CBInstall_requiredClassNames(): array {
        return [
            'CBModelTemplateCatalog'
        ];
    }



    /* -- CBModelTemplate interfaces -- -- -- -- -- */



    /**
     * @return object
     */
    static function
    CBModelTemplate_spec(
    ): stdClass {
        $pageSpec = CBViewPage::standardPageTemplate();

        CBModel::merge(
            $pageSpec,
            (object)[
                'classNameForKind' => 'MDBlogPostPageKind',
                'sections' => [
                    (object)[
                        'className' => 'CBPageTitleAndDescriptionView',
                        'showPublicationDate' => true,
                    ],
                    (object)[
                        'className' => 'CBArtworkView',
                    ],
                    (object)[
                        'className' => 'CBYouTubeView',
                    ],
                    (object)[
                        'className' => 'CBMessageView',
                    ],
                ],
            ]
        );

        return $pageSpec;
    }
    /* CBModelTemplate_spec() */



    /**
     * @return string
     */
    static function CBModelTemplate_title() {
        return 'Blog Post';
    }

}
