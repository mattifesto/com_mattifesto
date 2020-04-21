<?php

final class MDBlogPostPageTemplate {

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
    static function CBModelTemplate_spec() {
        $spec = (object)[
            'className' => 'CBViewPage',
            'classNameForSettings' => 'MDPageSettingsForResponsivePages',
            'classNameForKind' => 'MDBlogPostPageKind',
            'frameClassName' => 'MDPageFrame',
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
        ];

        return $spec;
    }
    /* CBModelTemplate_spec() */



    /**
     * @return string
     */
    static function CBModelTemplate_title() {
        return 'Blog Post';
    }

}
