<?php

error_reporting(
    E_ALL
);



/**
 *
 */
final class
CBWebsiteData {

    /**
     * @param object $websiteDataModel
     *
     * @return string
     */
    static function
    getAdminEmailAddress(
        stdClass $websiteDataModel
    ): string {
        return $websiteDataModel->CBWebsiteData_adminEmailAddress;
    }
    /* getAdminEmailAddress() */



    /**
     * @param object $websiteDataModel
     * @param string $adminEmailAddress
     *
     * @return void
     */
    static function
    setAdminEmailAddress(
        stdClass $websiteDataModel,
        string $adminEmailAddress
    ): void {
        $websiteDataModel->CBWebsiteData_adminEmailAddress = $adminEmailAddress;
    }
    /* setAdminEmailAddress() */



    /**
     * @param object $websiteDataModel
     *
     * @return string
     */
    static function
    getDatabaseName(
        stdClass $websiteDataModel
    ): string {
        return $websiteDataModel->CBWebsiteData_databaseName;
    }
    /* getDatabaseName() */



    /**
     * @param object $websiteDataModel
     * @param string $databaseName
     *
     * @return void
     */
    static function
    setDatabaseName(
        stdClass $websiteDataModel,
        string $databaseName
    ): void {
        $websiteDataModel->CBWebsiteData_databaseName = (
            $databaseName
        );
    }
    /* setDatabaseName() */



    /**
     * @param object $websiteDataModel
     *
     * @return string
     */
    static function
    getDatabasePassword(
        stdClass $websiteDataModel
    ): string {
        return $websiteDataModel->CBWebsiteData_databasePassword;
    }
    /* getDatabasePassword() */



    /**
     * @param object $websiteDataModel
     * @param string $databasePassword
     *
     * @return void
     */
    static function
    setDatabasePassword(
        stdClass $websiteDataModel,
        string $databasePassword
    ): void {
        $websiteDataModel->CBWebsiteData_databasePassword = (
            $databasePassword
        );
    }
    /* setDatabasePassword() */



    /**
     * @param object $websiteDataModel
     *
     * @return string
     */
    static function
    getDatabaseUsername(
        stdClass $websiteDataModel
    ): string {
        return $websiteDataModel->CBWebsiteData_databaseUsername;
    }
    /* getDatabaseUsername() */



    /**
     * @param object $websiteDataModel
     * @param string $databaseUsername
     *
     * @return void
     */
    static function
    setDatabaseUsername(
        stdClass $websiteDataModel,
        string $databaseUsername
    ): void {
        $websiteDataModel->CBWebsiteData_databaseUsername = (
            $databaseUsername
        );
    }
    /* setDatabaseUsername() */



    /**
     * @param object $websiteDataModel
     *
     * @return string
     */
    static function
    getDocumentRootDirectory(
        stdClass $websiteDataModel
    ): string {
        $websiteDirectory = CBWebsiteData::getWebsiteProjectDirectory(
            $websiteDataModel
        );

        return "{$websiteDirectory}/document_root";
    }
    /* getDocumentRootDirectory() */



    /**
     * @param object $websiteDataModel
     *
     * @return string
     */
    static function
    getPrimaryWebsiteDomain(
        stdClass $websiteDataModel
    ): string {
        return $websiteDataModel->CBWebsiteData_primaryWebsiteDomain;
    }
    /* getPrimaryWebsiteDomain() */



    /**
     * @param object $websiteDataModel
     * @param string $primaryWebsiteDomain
     *
     * @return void
     */
    static function
    setPrimaryWebsiteDomain(
        stdClass $websiteDataModel,
        string $primaryWebsiteDomain
    ): void {
        $websiteDataModel->CBWebsiteData_primaryWebsiteDomain = (
            $primaryWebsiteDomain
        );
    }
    /* setPrimaryWebsiteDomain() */



    /**
     * @param object $websiteDataModel
     *
     * @return string
     */
    static function
    getServerSpecificWebsiteDomain(
        stdClass $websiteDataModel
    ): string {
        return $websiteDataModel->CBWebsiteData_serverSpecificWebsiteDomain;
    }
    /* getServerSpecificWebsiteDomain() */



    /**
     * @param object $websiteDataModel
     * @param string $serverSpecificWebsiteDomain
     *
     * @return void
     */
    static function
    setServerSpecificWebsiteDomain(
        stdClass $websiteDataModel,
        string $serverSpecificWebsiteDomain
    ): void {
        $websiteDataModel->CBWebsiteData_serverSpecificWebsiteDomain = (
            $serverSpecificWebsiteDomain
        );
    }
    /* setServerSpecificWebsiteDomain() */



    /**
     * @param object $websiteDataModel
     *
     * @return string
     */
    static function
    getWebsiteProjectDirectory(
        stdClass $websiteDataModel
    ): string {
        $serverSpecificWebsiteDomain = (
            CBWebsiteData::getServerSpecificWebsiteDomain(
                $websiteDataModel
            )
        );

        $serverSpecificWebsiteReverseDomain = (
            Installer::convertDomainToReverseDomain(
                $serverSpecificWebsiteDomain
            )
        );

        $websitesDirectory = Installer::getColbyWebsitesDirectory();

        $websiteDirectory = (
            "{$websitesDirectory}/{$serverSpecificWebsiteReverseDomain}"
        );

        return $websiteDirectory;
    }
    /* getWebsiteProjectDirectory() */

}
/* CBWebsiteData */



/**
 *
 */
final class Installer {

    private static $actions = null;



    /**
     * @param object $websiteDataSpec
     *
     * @return void
     */
    static function
    createApacheVirtualHostConfigurationFiles(
        stdClass $websiteDataSpec
    ): void {
        $serverSpecificWebsiteDomain = (
            CBWebsiteData::getServerSpecificWebsiteDomain(
                $websiteDataSpec
            )
        );

        $websiteDirectory = CBWebsiteData::getWebsiteProjectDirectory(
            $websiteDataSpec
        );

        $serverAdminEmailAddress = CBWebsiteData::getAdminEmailAddress(
            $websiteDataSpec
        );

        $documentRootDirectory = CBWebsiteData::getDocumentRootDirectory(
            $websiteDataSpec
        );

        $logsDirectory = Installer::getLogsDirectory(
            $websiteDataSpec
        );

        $websiteDomains = [
            $serverSpecificWebsiteDomain,
        ];

        $primaryWebsiteDomain = CBWebsiteData::getPrimaryWebsiteDomain(
            $websiteDataSpec
        );

        if ($primaryWebsiteDomain !== $serverSpecificWebsiteDomain) {
            array_push(
                $websiteDomains,
                $primaryWebsiteDomain
            );
        }

        foreach ($websiteDomains as $websiteDomain) {
            $vh1 = <<<EOT
            <VirtualHost *:80>
                ServerName      {$websiteDomain}
                ServerAdmin     {$serverAdminEmailAddress}

                DocumentRoot    {$documentRootDirectory}
                ErrorLog        {$logsDirectory}/error.log
                CustomLog       {$logsDirectory}/access.log combined

                <Directory "{$documentRootDirectory}">
                    AllowOverride   all
                    Require         all granted
                </Directory>
            </VirtualHost>

            EOT;

            $reverseWebsiteDomain = Installer::convertDomainToReverseDomain(
                $websiteDomain
            );

            $confFilename = (
                "{$websiteDirectory}/{$reverseWebsiteDomain}.conf"
            );

            file_put_contents(
                $confFilename,
                $vh1
            );

            $localServerDomain = (
                Installer::convertDomainToLocalServerDomain(
                    $websiteDomain
                )
            );

            if ($localServerDomain === null) {
                continue;
            }

            $userHomeDirectory = Installer::getUserHomeDirectory();

            $sslCertificateFile = (
                "{$userHomeDirectory}/.acme.sh/" .
                "{$localServerDomain}/fullchain.cer"
            );

            $sslCertificateKeyFile = (
                "{$userHomeDirectory}/.acme.sh/" .
                "{$localServerDomain}/{$localServerDomain}.key"
            );

            $vh2 = <<<EOT
            <VirtualHost *:443>
                ServerName      {$websiteDomain}
                ServerAdmin     {$serverAdminEmailAddress}

                DocumentRoot    {$documentRootDirectory}
                ErrorLog        {$logsDirectory}/error.log
                CustomLog       {$logsDirectory}/access.log combined

                SSLEngine               on
                SSLCertificateFile      {$sslCertificateFile}
                SSLCertificateKeyFile   {$sslCertificateKeyFile}

                <Directory "{$documentRootDirectory}">
                    AllowOverride   all
                    Require         all granted
                </Directory>
            </VirtualHost>

            EOT;

            $confFilename = (
                "{$websiteDirectory}/{$reverseWebsiteDomain}_ssl.conf"
            );

            file_put_contents(
                $confFilename,
                $vh2
            );
        }
    }
    /* createApacheVirtualHostConfigurationFiles() */



    /**
     * @param object $websiteDataSpec
     *
     * @return string
     */
    static function
    createDatabaseCreationSQL(
        stdClass $websiteDataSpec
    ): string {
        $databaseName = CBWebsiteData::getDatabaseName(
            $websiteDataSpec
        );

        $databaseUsername = CBWebsiteData::getDatabaseUsername(
            $websiteDataSpec
        );

        $databasePassword = CBWebsiteData::getDatabasePassword(
            $websiteDataSpec
        );

        return <<<EOT
        create database
        {$databaseName};

        create user
        {$databaseUsername}@localhost
        identified with mysql_native_password by
        '{$databasePassword}';

        grant all on
        {$databaseName}.*
        to
        {$databaseUsername}@localhost;

        flush privileges;

        EOT;
    }
    /* createDatabaseCreationSQL() */



    /**
     * @return object
     */
    static function
    createWebsiteProject(
    ): stdClass {
        $websiteDataSpec = (object)[
            'className' => 'CBWebsiteData',
        ];

        $serverSpecificWebsiteDomain = (
            InstallerUI::askForServerSpecificWebsiteDomain()
        );

        CBWebsiteData::setServerSpecificWebsiteDomain(
            $websiteDataSpec,
            $serverSpecificWebsiteDomain
        );

        $primaryWebsiteDomain = InstallerUI::askForPrimaryWebsiteDomain();

        if ($primaryWebsiteDomain === '') {
            $primaryWebsiteDomain = $serverSpecificWebsiteDomain;
        }

        CBWebsiteData::setPrimaryWebsiteDomain(
            $websiteDataSpec,
            $primaryWebsiteDomain
        );

        // $secondaryWebsiteDomains = Installer::getSecondaryWebsiteDomains();

        $serverSpecificWebsiteReverseDomain = (
            Installer::convertDomainToReverseDomain(
                $serverSpecificWebsiteDomain
            )
        );

        CBWebsiteData::setDatabaseName(
            $websiteDataSpec,
            "{$serverSpecificWebsiteReverseDomain}_database"
        );

        CBWebsiteData::setDatabaseUserName(
            $websiteDataSpec,
            Installer::generateDatabaseUsername()
        );

        CBWebsiteData::setDatabasePassword(
            $websiteDataSpec,
            Installer::generateDatabasePassword()
        );

        CBWebsiteData::setAdminEmailAddress(
            $websiteDataSpec,
            InstallerUI::askForAdminEmailAddress()
        );

        /* create directories */

        Installer::createWebsiteProjectDirectories(
            $websiteDataSpec
        );

        $websiteDirectory = CBWebsiteData::getWebsiteProjectDirectory(
            $websiteDataSpec
        );

        Installer::createApacheVirtualHostConfigurationFiles(
            $websiteDataSpec
        );

        file_put_contents(
            "{$websiteDirectory}/create_database.sql",
            Installer::createDatabaseCreationSQL(
                $websiteDataSpec
            )
        );

        $documentRootDirectory = "{$websiteDirectory}/document_root";

        Installer::exec(
            "mkdir {$documentRootDirectory}"
        );

        return $websiteDataSpec;
    }
    /* createWebsiteProject() */



    /**
     * @param string $domain
     *
     * @return string|null
     */
    static function
    convertDomainToLocalServerDomain(
        string $domain
    ): ?string {
        $domainParts = explode(
            '.',
            $domain
        );

        $domainPartsCount = count(
            $domainParts
        );

        if (
            $domainPartsCount < 4
        ) {
            return null;
        }

        $serverPart = $domainParts[
            1
        ];

        if (
            preg_match('/^l[dtp][0-9]+$/', $serverPart)
        ) {
            $localServerDomainParts = $domainParts;

            array_shift(
                $localServerDomainParts
            );

            $localServerDomain = implode(
                '.',
                $localServerDomainParts
            );

            return $localServerDomain;
        }

        return null;
    }
    /* convertDomainToLocalServerDomain() */



    /**
     * @param string $websiteDomain
     *
     * @return string
     */
    static function
    convertDomainToReverseDomain(
        string $websiteDomain
    ): string {
        $parts = explode(
            '.',
            $websiteDomain
        );

        $parts = array_reverse(
            $parts
        );

        return implode(
            '_',
            $parts
        );
    }
    /* convertDomainToReverseDomain() */



    /**
     * @param object $websiteDataModel
     *
     * @return void
     */
    static function
    createWebsiteProjectDirectories(
        stdClass $websiteDataModel
    ): void {
        $websiteDirectory = CBWebsiteData::getWebsiteProjectDirectory(
            $websiteDataModel
        );

        if (
            file_exists($websiteDirectory)
        ) {
            throw new Exception('website directory already exists');
        }

        $websitesDirectory = Installer::getColbyWebsitesDirectory(
            $websiteDataModel
        );

        if (
            !is_dir($websitesDirectory)
        ) {
            mkdir(
                $websitesDirectory,
                0700
            );
        }

        mkdir(
            $websiteDirectory,
            0700
        );

        $logsDirectory = Installer::getLogsDirectory(
            $websiteDataModel
        );

        mkdir(
            $logsDirectory,
            0700
        );
    }
    /* createWebsiteProjectDirectories() */



    /**
     * @return void
     */
    static function
    doAction_Installer_actionName_brandNew(
    ): void {
        $websiteDomain = Installer::getWebsiteDomain();

        $websiteDirectory = Installer::convertDomainToAbsoluteDirectory(
            $websiteDomain
        );

        Installer::exec(
            "mkdir {$websiteDirectory}"
        );

        Installer::exec(
            "mkdir {$websiteDirectory}/logs"
        );

        $documentRootDirectory = "{$websiteDirectory}/document_root";

        Installer::exec(
            "git init {$documentRootDirectory} --initial-branch=main"
        );

        chdir(
            $documentRootDirectory
        );

        Installer::exec(
            'git submodule add ' .
            'https://github.com/mattifesto/colby.git ' .
            'colby'
        );

        Installer::exec(
            'git submodule add -b 5.x ' .
            'https://github.com/swiftmailer/swiftmailer.git ' .
            'swiftmailer'
        );

        Installer::exec(
            'git submodule update --init --recursive'
        );

        echo <<<EOT

            Go to https://{$websiteDomain}/colby/setup/ page finish installing.


        EOT;
    }
    /* doAction_Installer_actionName_brandNew() */



    /**
     * @return void
     */
    static function
    doAction_Installer_actionName_copyFrom(
        string $copyFromDirectory
    ): void {
        if (!is_dir($copyFromDirectory)) {
            throw new Exception(
                "{$copyFromDirectory} does not exist"
            );
        }

        echo <<<EOT

            -- -- -- -- -- WARNING -- -- -- -- --

            The --copyfrom option should only be used when developing Colby
            installation code. It does not create a viable website.



        EOT;

        $websiteDomain = Installer::getWebsiteDomain();

        $websiteDirectory = Installer::convertDomainToAbsoluteDirectory(
            $websiteDomain
        );

        Installer::exec(
            "mkdir {$websiteDirectory}"
        );

        Installer::exec(
            "mkdir {$websiteDirectory}/logs"
        );

        $documentRootDirectory = "{$websiteDirectory}/document_root";

        Installer::exec(
            "git init {$documentRootDirectory} --initial-branch=main"
        );

        chdir(
            $documentRootDirectory
        );

        Installer::exec(
            "cp -R {$copyFromDirectory}/colby {$documentRootDirectory}"
        );

        Installer::exec(
            "cp -R {$copyFromDirectory}/swiftmailer {$documentRootDirectory}"
        );

        echo <<<EOT

        Go to your site's /colby/setup/ page finish installing.


        EOT;
    }
    /* doAction_Installer_actionName_copyFrom() */



    /**
     * @return void
     */
    static function
    doAction_Installer_actionName_directories(
    ): void {
        $websiteDomain = Installer::getWebsiteDomain();

        $websiteDirectory = Installer::convertDomainToAbsoluteDirectory(
            $websiteDomain
        );

        Installer::exec(
            "mkdir {$websiteDirectory}"
        );

        Installer::exec(
            "mkdir {$websiteDirectory}/logs"
        );

        $documentRootDirectory = "{$websiteDirectory}/document_root";

        Installer::exec(
            "mkdir {$documentRootDirectory}"
        );

        file_put_contents(
            "{$documentRootDirectory}/index.php",
            <<<EOT
            <?php

            echo 'This is the test index.php for http[s]://{$websiteDomain}';

            EOT
        );

        echo <<<EOT

        A simple index.php file has been created

        {$documentRootDirectory}/index.php

        so that you can test your web server configuration. Once it is working
        replace this with your actual website code.


        EOT;
    }
    /* doAction_Installer_actionName_directories() */



    /**
     * @return void
     */
    static function
    doAction_Installer_actionName_existingRepository(
    ): void {
        $websiteDomain = Installer::getWebsiteDomain();

        $websiteDirectory = Installer::convertDomainToAbsoluteDirectory(
            $websiteDomain
        );

        $existngGitRepositoryURL = Installer::getExistingGitRepositoryURL();

        Installer::exec(
            "mkdir {$websiteDirectory}"
        );

        Installer::exec(
            "mkdir {$websiteDirectory}/logs"
        );

        $documentRootDirectory = "{$websiteDirectory}/document_root";

        Installer::exec(
            "git clone {$existngGitRepositoryURL} $documentRootDirectory"
        );

        chdir(
            $documentRootDirectory
        );

        Installer::exec(
            'git submodule update --init --recursive'
        );

        echo <<<EOT

        Go to https://{$websiteDomain}/colby/setup/ page finish installing.


        EOT;
    }
    /* doAction_Installer_actionName_existingRepository() */



    /**
     * @param string $command
     *
     * @return void
     */
    static function
    exec(
        string $command
    ): void {
        echo <<<EOT

        $ {$command}

        EOT;

        $output = [];

        exec(
            "{$command}",
            $output,
            $exitCode
        );

        $output = implode(
            "\n",
            $output
        );

        echo <<<EOT

        {$output}

        EOT;

        if (!empty($exitCode)) {
            echo <<<EOT

            ! returned exit code: {$exitCode}

            EOT;

            Installer::finish();
        }
    }
    /* exec() */



    /**
     * @return void
     */
    static function
    finish(
    ): void {
        unlink(__FILE__);
        exit;
    }
    /* finish() */



    /**
     * @return int
     */
    static function
    getActionIndex(
    ): int {
        while (true) {
            echo "\nHow would you like to create a new website instance?\n\n";

            for (
                $index = 0;
                $index < count(Installer::$actions);
                $index += 1
            ) {
                $description = (
                    Installer::$actions[$index]->Installer_actionDescription
                );

                echo "{$index}) {$description}\n";
            }

            echo "\nenter choice: ";

            $actionIndex = Installer::valueAsInt(
                fgets(STDIN),
            );

            if (
                $actionIndex !== null &&
                $actionIndex >= 0 &&
                $actionIndex < count(Installer::$actions)
            ) {
                return $actionIndex;
            }
        }
    }
    /* getActionIndex() */



    /**
     * @return string
     */
    static function
    getExistingGitRepositoryURL(
    ): string {
        while (true) {
            echo <<<EOT

            Enter the git URL to create an instance of an existing website or
            press return to create a brand new website.

            Existing Website Git URL:
            EOT;

            $existngGitRepositoryURL = (
                trim(
                    fgets(STDIN),
                )
            );

            exec(
                "git ls-remote {$existngGitRepositoryURL} 2>&1",
                $output,
                $exitCode
            );

            if ($exitCode === 0) {
                return $existngGitRepositoryURL;
            }
        }
    }
    /* getExistingGitRepositoryURL() */



    /**
     * @return string
     */
    static function
    getWebsiteDomain(
    ): string {
        while (true) {
            echo <<<EOT

            Enter the full domain for the website, for example
            "mattifesto.ld17.mtfs.us"

            website domain:
            EOT;

            $websiteDomain = (
                trim(
                    fgets(STDIN),
                )
            );

            $result = filter_var(
                $websiteDomain,
                FILTER_VALIDATE_DOMAIN,
                FILTER_FLAG_HOSTNAME
            );

            if ($result !== false) {
                return $websiteDomain;
            }
        }
    }
    /* getWebsiteDomain() */



    /**
     * @param Throwable $error
     *
     * @return void
     */
    static function
    handleError(
        Throwable $error
    ): void {
        $oneLineErrorReport = Installer::throwableToOneLineErrorReport(
            $error
        );

        echo <<<EOT

            {$oneLineErrorReport}

            EOT
        ;

        Installer::finish();
    }
    /* handleError() */



    /**
     * @return void
     */
    static function
    install(
    ): void {
        set_exception_handler(
            function (Throwable $error) {
                Installer::handleError($error);
            }
        );

        $options = getopt(
            '',
            [
                'copyfrom:'
            ]
        );

        Installer::$actions = [
            (object)[
                'Installer_actionName' => (
                    'Installer_actionName_brandNew'
                ),
                'Installer_actionDescription' => (
                    'create a brand new website'
                ),
            ],
            (object)[
                'Installer_actionDescription' => (
                    'create a website using an existing Git repository'
                ),
                'Installer_actionName' => (
                    'Installer_actionName_existingRepository'
                ),
            ],
            (object)[
                'Installer_actionDescription' => (
                    'create directories for a website'
                ),
                'Installer_actionName' => (
                    'Installer_actionName_directories'
                ),
            ],
        ];

        if (
            isset(
                $options['copyfrom']
            )
        ) {
            $copyFromDirectory = $options['copyfrom'];

            Installer::doAction_Installer_actionName_copyFrom(
                $copyFromDirectory
            );
        } else {
            $actionIndex = Installer::getActionIndex();
            $actionName = Installer::$actions[$actionIndex]->Installer_actionName;
            $functionName = "Installer::doAction_{$actionName}";

            call_user_func(
                $functionName
            );
        }

        Installer::finish();
    }
    /* install() */



    /**
     * This function's code is copied from the Colby CBException class.
     *
     * @param Throwable $throwable
     *
     * @return string
     */
    static function
    throwableToOneLineErrorReport(
        Throwable $throwable
    ): string {
        $message = $throwable->getMessage();
        $basename = basename($throwable->getFile());
        $line = $throwable->getLine();

        return "\"{$message}\" in {$basename} line {$line}";
    }
    /* throwableToOneLineErrorReport() */



    /**
     * Copied from CBConvert.php
     *
     * @oaram mixed $value
     *
     * @return int|null
     */
    static function
    valueAsInt(
        /* mixed */ $value
    ): ?int {
        if (is_string($value)) {
            $value = trim($value);
        }

        if (is_numeric($value)) {
            $intValue = intval($value);

            if ($intValue == $value) {
                return $intValue;
            }
        }

        return null;
    }
    /* valueAsInt() */

}
/* Installer */



/**
 *
 */
final class
InstallerUI {

    /**
     * @return string
     */
    static function
    askForAdminEmailAddress(
    ): string {
        echo <<<EOT

        The admin email address will be used in the configuration files for the
        Apache web server.

        EOT;

        while (true) {
            echo "\n", 'enter admin email address: ';

            $adminEmailAddress = (
                trim(
                    fgets(STDIN),
                )
            );

            $result = filter_var(
                $adminEmailAddress,
                FILTER_VALIDATE_EMAIL
            );

            if ($result !== false) {
                return $result;
            }
        }
    }
    /* askForAdminEmailAddress() */



    /**
     * @return string
     *
     *      Returns the primary website domain or an empty string if the user
     *      wants to use the server specific website domain as the primary
     *      domain.
     */
    static function
    askForPrimaryWebsiteDomain(
    ): string {
        echo <<<EOT

            The primary website domain is the most preferred domain for a
            website. For the Mattifesto production website it is
            "mattifesto.com". Development and test websites most often just use
            the server specific website domain as the primary website domain.

            If this website instance does not have a primary website domain just
            press return.

        EOT;

        while (true) {
            echo "\nenter the primary website domain or press return: ";

            $result = InstallerUI::inputDomain();

            if (
                $result->value === '' ||
                $result->isValidDomain
            ) {
                return $result->value;
            }
        }
    }
    /* askForPrimaryWebsiteDomain() */



    /**
     * @return string
     */
    static function
    askForServerSpecificWebsiteDomain(
    ): string {
        echo <<<EOT

            The server specific website domain is a domain that identifies this
            website as it exists only on this server. Once the website is no
            longer needed on this server this domain will never be used again.
            The server specific domain is intended to indicate the purpose of
            this website instance and allows access to this specific website
            instance if the website's primary domain is not server specific.

            Development and test websites will often have only a server specific
            domain and it will be used as the primary domain as well.

            Production sites will usually have a different primary domain that
            moves with the website from server to server.

            The domain "mattifesto.ld17.mtfs.us" is an example of a Mattifesto
            website server specific domain and indicates that the website
            instance is used for development and is on the 17th web server which
            is a local network development web server.

        EOT;

        while (true) {
            echo "\nenter server specific domain: ";

            $result = InstallerUI::inputDomain();

            if ($result->isValidDomain) {
                return $result->value;
            }
        }
    }
    /* askForServerSpecificWebsiteDomain() */



    /**
     * This function presents no user interface, so the calling function should.
     * It simply allows the user to enter a string.
     *
     * @return stdClass
     *
     *      {
     *          value: string
     *          isValidDomain: bool
     *      }
     */
    static function
    inputDomain(
    ): stdClass {
        $value = (
            trim(
                fgets(STDIN),
            )
        );

        $result = filter_var(
            $value,
            FILTER_VALIDATE_DOMAIN,
            FILTER_FLAG_HOSTNAME
        );

        return (object)[
            'value' => $value,
            'isValidDomain' => $result !== false,
        ];
    }
    /* inputDomain() */

}
/* InstallerUI */

Installer::install();
