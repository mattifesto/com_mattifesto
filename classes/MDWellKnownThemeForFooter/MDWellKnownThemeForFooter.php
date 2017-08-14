<?php

/**
 * @deprecated remove class after install has run once
 */
final class MDWellKnownThemeForFooter {

    const ID = '35f349139b9616b8d9b689a8fc2e18edc48bd4cf';

    /**
     * @return null
     */
    static function install() {
        CBDB::transaction(function () {
            CBModels::deleteByID(MDWellKnownThemeForFooter::ID);
        });
    }
}
