<?php

final class MDStandardModels {
    const CBThemeIDForMDStandardPageFooterView = '35f349139b9616b8d9b689a8fc2e18edc48bd4cf';

    /**
     * @return null
     */
    public static function install() {
        include __DIR__ . '/MDStandardModelsInstall.php';
    }
}
