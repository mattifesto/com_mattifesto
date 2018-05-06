<?php

final class MDPageTemplate {

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
        return ['CBModelTemplateCatalog'];
    }

    /**
     * @return object
     */
    static function CBModelTemplate_spec() {
        $spec = (object)[
            'className' => 'CBViewPage',
            'frameClassName' => 'MDPageFrame',
        ];

        $spec->sections[] = (object)[
            'className' => 'CBPageTitleAndDescriptionView',
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
        return 'Page';
    }
}
