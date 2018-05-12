<?php

final class MDMainMenuUpdateTask {

    /**
     * @return void
     */
    static function CBInstall_configure(): void {
        MDMainMenuUpdateTask::restart();
    }

    /**
     * @param ID $ID
     *
     * @return void
     */
    static function CBTasks2_run(string $ID): void {
        if ($ID !== MDMainMenuUpdateTask::ID()) {
            throw new Exception("This task was run with the wrong ID: {$ID}");
        }

        /* menu */

        $originalMenuSpec = CBModels::fetchSpecByID(MDMainMenu::ID());

        if (empty($originalMenuSpec)) {
            throw new Exception('The menu model does not exist.');
        }

        $menuSpec = CBModel::clone($originalMenuSpec);

        /* remove previous topic menu items */

        $menuItems = CBModel::valueToArray($menuSpec, 'items');

        $menuItems = array_filter($menuItems, function ($item) {
            return empty($item->isTopicItem);
        });

        /* topics */

        $topics = CBModels::fetchModelsByClassName('MDTopic');

        $topics = array_filter($topics, function ($topic) {
            return empty($topic->isHidden);
        });

        usort($topics, function($topica, $topicb) {
            $sorta = CBModel::valueAsInt($topica, 'sort');
            $sortb = CBModel::valueAsInt($topicb, 'sort');

            if ($sorta < $sortb) {
                return -1;
            } else if ($sorta > $sortb) {
                return 1;
            } else {
                return 0;
            }
        });

        $topicsMenuItems = array_map(function ($topic) {
            $URI = CBModel::valueToString($topic, 'URI');

            return (object)[
                'className' => 'CBMenuItem',
                'isTopicItem' => true,
                'name' => CBModel::valueToString($topic, 'moniker'),
                'text' => CBModel::valueToString($topic, 'title'),
                'URL' => "/{$URI}/",
            ];
        }, $topics);

        /* insert current topic menu items */

        array_splice($menuItems, 0, 0, $topicsMenuItems);

        /* add blog menu item */

        if (CBModel::indexOf($menuItems, 'URL', '/blog/') === null) {
            array_push($menuItems, (object)[
                'className' => 'CBMenuItem',
                'name' => 'blog',
                'text' => 'Blog',
                'URL' => '/blog/',
            ]);
        }

        /* save */

        $menuSpec->items = $menuItems;

        if ($menuSpec != $originalMenuSpec) {
            CBDB::transaction(function () use ($menuSpec) {
                CBModels::save($menuSpec);
            });
        }
    }

    /**
     * @return void
     */
    static function restart(): void {
        CBTasks2::restart(__CLASS__, MDMainMenuUpdateTask::ID(), /* priority */ 75);
    }

    /**
     * @return ID
     */
    static function ID(): string {
        return 'cd4362862cdfa38c405ad78e4fdf31ac8c142dcc';
    }
}
