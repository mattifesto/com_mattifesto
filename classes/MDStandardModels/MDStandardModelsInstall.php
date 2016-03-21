<?php

$specs = [
    (object)[
        'ID' => MDStandardModels::CBThemeIDForMDStandardPageFooterView,
        'className' => 'CBTheme',
        'classNameForKind' => 'MDStandardPageFooterView',
        'title' => 'Standard Page Footer',
    ],
];

$IDs = array_map(function ($spec) { return $spec->ID; }, $specs);
$models = CBModels::fetchModelsByID($IDs);

foreach ($specs as $spec) {
    if (empty($models[$spec->ID])) {
        CBModels::save([$spec]);
    }
}
