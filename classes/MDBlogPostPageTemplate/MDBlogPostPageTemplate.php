<?php

final class MDBlogPostPageTemplate {

    /**
     * @return void
     */
    static function CBInstall_install(): void {
        CBModelTemplates::installTemplate(__CLASS__);
    }

    /**
     * @return [string]
     */
    static function CBInstall_requiredClassNames(): array {
        return ['CBModelTemplates'];
    }

    /**
     * @return object
     */
    static function CBModelTemplate_spec() {
        $spec = (object)[
            'className' => 'CBViewPage',
            'classNameForKind' => 'MDBlogPostPageKind',
            'frameClassName' => 'MDPageFrame',
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
        return 'Blog Post';
    }
}
