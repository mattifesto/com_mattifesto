<?php

$installScriptFilepath = cbsitedir() . '/install/install.php';

header(
    'Content-type: ',
    mime_content_type(
        $installScriptFilepath
    )
);

echo file_get_contents(
    $installScriptFilepath
);
