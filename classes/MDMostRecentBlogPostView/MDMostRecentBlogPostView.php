<?php

/**
 * @deprecated 2020_05_28
 *
 *      Can be removed after updated on each website.
 */
final class MDMostRecentBlogPostView {

    /* -- CBInstall interfaces -- -- -- -- -- */



    /**
     * @return void
     */
    static function CBInstall_install(): void {
        CBViewCatalog::installView(
            __CLASS__,
            (object)[
                'isUnsupported' => true,
            ]
        );
    }
    /* CBInstall_install() */



    /**
     * @return [string]
     */
    static function CBInstall_requiredClassNames(): array {
        return [
            'CBViewCatalog',
        ];
    }
    /* CBInstall_requiredClassNames() */



    /* -- CBView interfaces -- -- -- -- -- */



    /**
     * @param object $model
     *
     * @return null
     */
    static function CBView_render(
        stdClass $model
    ): void {
        echo '<!-- MDMostRecentBlogPostView -->';
    }
    /* CBView_render() */



    /* -- CBModel interfaces -- -- -- -- -- */



    /**
     * @param object $spec
     *
     * @return object
     */
    static function CBModel_build(
        stdClass $spec
    ): stdClass {
        return (object)[];
    }
    /* CBModel_build() */



    /**
     * @param object
     */
    static function CBModel_upgrade(
        stdClass $spec
    ): stdClass {
        return (object)[
            'className' => 'CBPageListView2',
            'classNameForKind' => 'MDBlogPostPageKind',
            'CSSClassNames' => 'recent',
        ];
    }
    /* CBModel_upgrade() */

}
