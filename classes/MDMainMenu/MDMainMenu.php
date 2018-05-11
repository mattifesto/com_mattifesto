<?php

final class MDMainMenu {

    /**
     * @return void
     */
    static function CBInstall_install(): void {
        $originalSpec = CBModels::fetchSpecByID(MDMainMenu::ID());

        if (empty($originalSpec)) {
            $spec = (object)[
                'ID' => MDMainMenu::ID(),
                'title' => 'Mattifesto',
                'titleURI' => '/',
            ];
        } else {
            $spec = CBModel::clone($originalSpec);
        }

        $spec->className = 'CBMenu';

        /* save if modified */

        if ($spec != $originalSpec) {
            CBDB::transaction(function () use ($spec) {
                CBModels::save($spec);
            });
        }
    }

    /**
     * @return [string]
     */
    static function CBInstall_requiredClassNames(): array {
        return ['CBModels'];
    }

    /**
     * @return ID
     */
    static function ID(): string {
        return '56dbb447cf11414e5c3df442edc7ca6c3967a9ca';
    }
}
