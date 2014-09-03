<?php

/**
 * Library database installation scripts.
 *
 * These are included so that if a new table is added it only has to be added
 * to the installation script and an upgrade script does not also have to be
 * created. Installation scripts should do nothing if the database elements
 * for the library are already installed.
 */

include CBSystemDirectory . '/setup/install-database.php';

/**
 * This is a hand maintained upgrade list specific to this website. Scripts
 * should be removed and deprecated once all known installations have
 * been upgraded to keep the upgrade process fast and simple.
 */

include CBSystemDirectory . '/setup/upgrade-0082-00.php';
