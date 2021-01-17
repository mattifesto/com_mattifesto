<?php

final class MDMainMenu {

    /* -- CBInstall interfaces -- */



    /**
     * @return void
     */
    static function
    CBInstall_install(
    ): void {
        $updater = CBModelUpdater::fetchByCBID(
            MDMainMenu::ID()
        );

        $menuSpec = ($updater->CBModelUpdater_getSpec)();

        CBModel::setClassName(
            $menuSpec,
            'CBMenu'
        );

        CBMenu::setTitle(
            $menuSpec,
            'Mattifesto'
        );

        CBMenu::setTitleURL(
            $menuSpec,
            '/'
        );

        ($updater->CBModelUpdater_save)();
    }
    /* CBInstall_install() */



    /**
     * @return [string]
     */
    static function
    CBInstall_requiredClassNames(
    ): array {
        return [
            'CBModels',
        ];
    }
    /* CBInstall_requiredClassNames() */



    /* -- functions -- */



    /**
     * @return ID
     */
    static function
    ID(
    ): string {
        return '56dbb447cf11414e5c3df442edc7ca6c3967a9ca';
    }
    /* ID() */

}
