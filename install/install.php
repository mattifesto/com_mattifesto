<?php

error_reporting(
    E_ALL
);

Installer::install();



/**
 *
 */
final class
Installer {

    private static $actions = null;



    /**
     * @return object
     */
    static function
    createDocumentRootDirectory(
    ): void {
        $projectDirectory = Installer::getWebsiteProjectDirectory();

        $documentRootDirectory = "{$projectDirectory}/document_root";

        Installer::exec(
            "mkdir {$documentRootDirectory}"
        );
    }
    /* createDocumentRootDirectory() */



    /**
     * @return void
     */
    static function
    createLogsDirectory(
    ): void {
        $logsDirectory = Installer::getLogsDirectory();

        echo "Creating directory: {$logsDirectory}";

        mkdir(
            $logsDirectory,
        );
    }
    /* createLogsDirectory() */



    /**
     * The --copy-local-colby option can be used when doing development work on
     * colby that hasn't been committed yet. It requires calling install
     * directly instead of using the standard curl method. This will not create
     * a viable project, but will work for testing.
     *
     * @return void
     */
    static function
    doAction_Installer_actionName_brandNew(
    ): void {
        $optionsStatus = getopt(
            '',
            [
                'copy-local-colby'
            ]
        );

        $copyLocalColby = array_key_exists(
            'copy-local-colby',
            $optionsStatus
        );

        $localColbyDirectory = __DIR__ . '/../colby';

        if (!is_dir($localColbyDirectory)) {
            error_log('There is no local colby to copy.');
        }

        Installer::createLogsDirectory();

        $documentRootDirectory = Installer::getDocumentRootDirectory();

        Installer::exec(
            "git init {$documentRootDirectory} --initial-branch=main"
        );

        chdir(
            $documentRootDirectory
        );

        if ($copyLocalColby) {
            Installer::exec(
                "cp -R {$localColbyDirectory} colby"
            );
        } else {
            Installer::exec(
                'git submodule add ' .
                'https://github.com/mattifesto/colby.git' .
                ' colby'
            );
        }

        Installer::exec(
            'git submodule add -b 5.x ' .
            'https://github.com/swiftmailer/swiftmailer.git ' .
            'swiftmailer'
        );

        Installer::exec(
            'git submodule update --init --recursive'
        );

        echo <<<EOT

            A new Colby project has been created.


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

        Installer::createLogsDirectory();

        Installer::createDocumentRootDirectory();

        $documentRootDirectory = Installer::getDocumentRootDirectory();

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

        A colby project was created by copying from the directory
        {$copyFromDirectory}


        EOT;
    }
    /* doAction_Installer_actionName_copyFrom() */



    /**
     * @return void
     */
    static function
    doAction_Installer_actionName_directories(
    ): void {
        Installer::createLogsDirectory();

        Installer::createDocumentRootDirectory();

        $documentRootDirectory = Installer::getDocumentRootDirectory();

        $filename = "{$documentRootDirectory}/index.php";

        $contents = <<<EOT
        <?php

        echo <<<END

        This is the test index.php.

        END;

        EOT;

        file_put_contents(
            $filename,
            $contents
        );

        echo <<<EOT

            A simple index.php file has been created:

                {$documentRootDirectory}/index.php

            so that you can test your web server configuration. Once it is
            working replace this with your actual website code.


        EOT;
    }
    /* doAction_Installer_actionName_directories() */



    /**
     * @return void
     */
    static function
    doAction_Installer_actionName_existingRepository(
    ): void {
        Installer::createLogsDirectory();

        Installer::createDocumentRootDirectory();

        $documentRootDirectory = Installer::getDocumentRootDirectory();

        $existngGitRepositoryURL = Installer::getExistingGitRepositoryURL();

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

        The Colby project has been created.


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
        $websiteProjectDirectory = Installer::getWebsiteProjectDirectory();
        $installScriptDirectory = __DIR__;

        /**
         * We only delete the install script if it's being run from the website
         * project directory.
         */

        if ($websiteProjectDirectory === $installScriptDirectory) {
            unlink(__FILE__);
        }

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
    getDocumentRootDirectory(
    ): string {
        $websiteDirectory = Installer::getWebsiteProjectDirectory();

        return "{$websiteDirectory}/document_root";
    }
    /* getDocumentRootDirectory() */



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
    getLogsDirectory(
    ): string {
        $websiteDirectory = Installer::getWebsiteProjectDirectory();

        return "{$websiteDirectory}/logs";
    }
    /* getLogsDirectory() */



    /**
     * @return string
     */
    static function
    getWebsiteProjectDirectory(
    ): string {
        return getcwd();
    }
    /* getWebsiteProjectDirectory() */



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

        set_error_handler(
            function(
                $errno,
                $errstr,
                $errfile,
                $errline
            ) {
                if (0 === error_reporting()) {
                    return false;
                }

                throw new ErrorException(
                    $errstr,
                    0,
                    $errno,
                    $errfile,
                    $errline
                );
            }
        );

        $websiteProjectDirectory = Installer::getWebsiteProjectDirectory();

        echo "Creating a new website project in: {$websiteProjectDirectory}";

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
