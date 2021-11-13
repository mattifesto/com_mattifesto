<?php

final class
MDPageTemplate {

    /**
     * @return void
     */
    static function CBInstall_install(): void {
        CBModelTemplateCatalog::install(__CLASS__);
        CBModelTemplateCatalog::installLivePageTemplate(__CLASS__);
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
    static function
    CBModelTemplate_spec(
    ): stdClass {
        $pageSpec = CBViewPage::standardPageTemplate();

        CBModel::merge(
            $pageSpec,
            (object)[
                'sections' => [
                    (object)[
                        'className' => 'CBPageTitleAndDescriptionView',
                    ],
                    (object)[
                        'className' => 'CBArtworkView',
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
        return 'Page';
    }

}
