<?php

final class Installer {

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



        /* for Colby development only */

        if (
            isset(
                $options['copyfrom']
            )
        ) {
            $copyFromDirectory = $options['copyfrom'];

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
        } else {
            $copyFromDirectory = '';
        }



        /* website directory */

        echo <<<EOT

        Enter the directory for the website.

        directory:
        EOT;

        $websiteDirectory = (
            __DIR__ .
            '/' .
            rtrim(
                fgets(STDIN),
                "\r\n"
            )
        );



        // @TODO check if website directory already EXISTS

        Installer::exec(
            "git init {$websiteDirectory} --initial-branch=main"
        );

        chdir($websiteDirectory);

        if (empty($copyFromDirectory)) {
            Installer::exec(
                'git submodule add ' .
                'https://github.com/mattifesto/colby.git ' .
                'colby'
            );
        } else {
            Installer::exec(
                "cp -R {$copyFromDirectory}/colby " .
                "{$websiteDirectory}"
            );
        }

        if (empty($copyFromDirectory)) {
            Installer::exec(
                'git submodule add -b 5.x ' .
                'https://github.com/swiftmailer/swiftmailer.git ' .
                'swiftmailer'
            );

            Installer::exec(
                'git submodule update --init --recursive'
            );
        } else {
            Installer::exec(
                "cp -R {$copyFromDirectory}/swiftmailer " .
                "{$websiteDirectory}"
            );
        }

        echo (
            "Go to your site's /colby/setup/ page " .
            "to finish installing.\n\n"
        );

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

}

Installer::install();
