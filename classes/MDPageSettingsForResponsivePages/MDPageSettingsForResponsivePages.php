<?php

final class MDPageSettingsForResponsivePages {

    /**
     * @return [string]
     */
    static function CBPageSettings_htmlElementClassNames(): array {
        return ['CBDarkTheme', 'CBStyleSheet'];
    }

    /**
     * @return [string]
     */
    static function CBPageSettings_requiredClassNames(): array {
        return [
            'CBEqualizePageSettingsPart',
            'CBResponsiveViewportPageSettingsPart',
            'CBGoogleTagManagerPageSettingsPart',
            'CBFacebookPageSettingsPart',
        ];
    }
}
