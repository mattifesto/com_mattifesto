<?php

final class Installer {

    private static $actions = null;



    /**
     * @param string $websiteDomain
     *
     * @return string
     */
    static function
    convertDomainToAbsoluteDirectory(
        string $websiteDomain
    ): string {
        $parts = explode(
            '.',
            $websiteDomain
        );

        $parts = array_reverse(
            $parts
        );


        $directory = implode(
            '_',
            $parts
        );

        return __DIR__ . "/{$directory}";
    }
    /* convertDomainToAbsoluteDirectory() */



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

            Go to your site's /colby/setup/ page finish installing.


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

        echo <<<EOT

            Now you must create the {$documentRootDirectory} for your website.


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

        echo <<<EOT

            Go to your site's /colby/setup/ page finish installing.


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
            "{$command} 2>&1",
            $output,
            $exitCode
        );

        if (!empty($exitCode)) {
            echo <<<EOT

                ! returned exit code: {$exitCode}

            EOT;

            Installer::finish();
        }

        $output = implode(
            "\n",
            $output
        );

        echo <<<EOT

        {$output}

        EOT;
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

Installer::install();
