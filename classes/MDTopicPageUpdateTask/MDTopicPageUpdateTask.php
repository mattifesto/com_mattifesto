<?php

final class MDTopicPageUpdateTask {

    /**
     * @param ID $topicID
     *
     * @return void
     */
    static function CBTasks2_run(string $topicID): void {
        $topic = CBModels::fetchModelByID($topicID);
        $URI = CBModel::valueToString($topic, 'URI');
        $pageIDs = CBPages::fetchPublishedPageIDsByURI($URI);

        if (empty($pageIDs)) {
            $pageIDs = [CBHex160::random()];
        }

        foreach ($pageIDs as $pageID) {
            MDTopicPageUpdateTask::updatePage($pageID, $topic);
        }
    }

    /**
     * @param ID $pageID
     * @param model $topic
     *
     * @return void
     */
    static function updatePage(string $pageID, stdClass $topic): void {
        $content = CBModel::valueToString($topic, 'content');
        $title = CBModel::valueToString($topic, 'title');
        $URI = CBModel::valueToString($topic, 'URI');
        $originalPageSpec = CBModels::fetchSpecByID($pageID);

        if (empty($originalPageSpec)) {
            $pageSpec = (object)[
                'ID' => $pageID,
            ];
        } else {
            $pageSpec = CBModel::clone($originalPageSpec);
        }

        $timestamp = CBModel::valueAsInt($pageSpec, 'publicationTimeStamp');

        if ($timestamp === null) {
            $timestamp = time();
        }

        CBModel::merge($pageSpec, (object)[
            'className' => 'CBViewPage',
            'classNameForSettings' => 'MDPageSettingsForResponsivePages',
            'frameClassName' => 'MDPageFrame',
            'isPublished' => true,
            'publicationTimeStamp' => $timestamp,
            'title' => $title,
            'URI' => $URI,
        ]);

        $subviews = CBView::getSubviews($pageSpec);

        /* title view */

        if (CBView::findSubview($pageSpec, 'className', 'CBPageTitleAndDescriptionView') === null) {
            array_unshift($subviews, (object)[
                'className' => 'CBPageTitleAndDescriptionView',
            ]);
        }

        /* content view */

        $contentViewSpec = CBView::findSubview($pageSpec, 'isTopicContentView', true);

        if (empty($contentViewSpec)) {
            $contentViewSpec = (object)[
                'isTopicContentView' => true,
            ];

            array_push($subviews, $contentViewSpec);
        }

        CBModel::merge($contentViewSpec, (object)[
            'className' => 'CBMessageView',
            'markup' => $content,
        ]);

        /* save */

        CBView::setSubviews($pageSpec, $subviews);

        if ($pageSpec != $originalPageSpec) {
            CBDB::transaction(function () use ($pageSpec) {
                CBModels::save($pageSpec);
            });
        }
    }
}
