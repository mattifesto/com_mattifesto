<?php

final class MDPage_payment {

    /* -- CBInstall interfaces -- -- -- -- -- */



    /**
     * @return void
     */
    static function CBInstall_configure(): void {
        $pageModelCBID = MDPage_payment::getPageModelCBID();

        $pageSpecUpdates = CBModelTemplateCatalog::fetchLivePageTemplate(
            (object)[
                'ID' => $pageModelCBID,
                'classNameForKind' => 'MDGeneratedPageKind',
                'isPublished' => true,
                'title' => 'Make a Payment',
                'URI' => 'payment',
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

        $sourceCBID = '1abbcd42fccee9107f848788870c1936615c9016';

        CBSubviewUpdater::push(
            $updatedPageSpec,
            'sourceCBID',
            $sourceCBID,
            (object)[
                'className' => 'CBPageTitleAndDescriptionView',
                'sourceCBID' => $sourceCBID,
            ]
        );


        /* SCFreeFormBuyView */

        $sourceCBID = 'e86da8de8565cf9e5426257667da87b49ae228f3';

        CBSubviewUpdater::push(
            $updatedPageSpec,
            'sourceCBID',
            $sourceCBID,
            (object)[
                'className' => 'SCFreeFormBuyView',
                'sourceCBID' => $sourceCBID,
            ]
        );


        /* CBMessageView */

        $sourceCBID = '5be7a92630ef688fc5822a03b67d2515df2038a8';

        CBSubviewUpdater::push(
            $updatedPageSpec,
            'sourceCBID',
            $sourceCBID,
            (object)[
                'className' => 'CBMessageView',
                'sourceCBID' => $sourceCBID,
            ]
        );


        /* save */

        CBModelUpdater::save($updater);
    }
    /* CBInstall_configure() */



    /* -- functions -- -- -- -- -- */



    static function getPageModelCBID(): string {
        return '1987a08c319c82f4bf32fe1ef05411f2feb9127e';
    }

}
