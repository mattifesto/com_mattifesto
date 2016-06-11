<?php

final class MDWellKnownThemeForFooter {

    const ID = '35f349139b9616b8d9b689a8fc2e18edc48bd4cf';

    /**
     * @return null
     */
    public static function install() {
        $spec = CBModels::fetchSpecByID(MDWellKnownThemeForFooter::ID);

        if ($spec === false) {
            $spec = (object)[
                'ID' => MDWellKnownThemeForFooter::ID,
            ];
        }

        $originalSpec = clone $spec;

        /* set or reset required properties */
        $spec->className = 'CBTheme';
        $spec->classNameForKind = 'MDStandardPageFooterView';
        $spec->classNameForTheme = 'MDWellKnownThemeForFooter';
        $spec->description = 'The default theme for MDStandardPageFooterView.';
        $spec->title = 'MDWellKnownThemeForFooter';

        if ($spec != $originalSpec) {
            CBModels::save([$spec]);
        }
    }

    /**
     * @return [string]
     */
    public static function requiredCSSURLs() {
        return [Colby::flexnameForCSSForClass(CBSiteURL, __CLASS__)];
    }
}
