<?php

final class Page_MDDeveloperBlog {

    /* -- CBInstall interfaces -- -- -- -- -- */



    /**
     * @return void
     */
    static function CBInstall_configure(): void {
        $pageModelCBID = Page_MDDeveloperBlog::getPageModelCBID();

        $pageSpecUpdates = CBModelTemplateCatalog::fetchLivePageTemplate(
            (object)[
                'ID' => $pageModelCBID,
                'classNameForKind' => 'MDGeneratedPageKind',
                'isPublished' => true,
                'title' => 'Mattifesto Developer Blog',
                'URI' => 'developer/blog',
            ]
        );


        /* fetch and make simple updates */

        $updater = CBModelUpdater::fetch(
            $pageSpecUpdates
        );

        $updatedPageSpec = $updater->working;


        /* publicationTimeStamp */

        $publicationTimeStamp = CBModel::valueAsInt(
            $updatedPageSpec,
            'publicationTimeStamp'
        );

        if ($publicationTimeStamp === null) {
            $updatedPageSpec->publicationTimeStamp = time();
        }


        /* CBPageTitleAndDescriptionView */

        $sourceCBID = 'f1db95952c6e39ae5e1f55a27e7040e3c64c31bf';

        CBSubviewUpdater::push(
            $updatedPageSpec,
            'sourceCBID',
            $sourceCBID,
            (object)[
                'className' => 'CBPageTitleAndDescriptionView',
                'sourceCBID' => $sourceCBID,
            ]
        );


        /* CBPageListView2 */

        $sourceCBID = '47eb3a1dd971b28f8ee2854f71d4b77f3f12b816';

        CBSubviewUpdater::push(
            $updatedPageSpec,
            'sourceCBID',
            $sourceCBID,
            (object)[
                'className' => 'CBPageListView2',
                'classNameForKind' => 'MDDeveloperBlogPostPageKind',
                'sourceCBID' => $sourceCBID,
            ]
        );


        /* save */

        CBModelUpdater::save($updater);
    }



    /* -- functions -- -- -- -- -- */



    /**
     * @return CBID
     */
    static function getPageModelCBID(): string {
        return '8b7f2021c6d649cc7f71672339f895d9702d25e0';
    }

}
