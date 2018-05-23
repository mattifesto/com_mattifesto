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

        if (empty($URI)) {
            CBLog::log((object)[
                'message' => 'The model URI is empty.',
                'severity' => 4,
            ]);

            return;
        }

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
        $redirectToURI = CBModel::valueToString($topic, 'redirectToURI');
        $title = CBModel::valueToString($topic, 'title');
        $URI = CBModel::valueToString($topic, 'URI');
        $originalPageSpec = CBModels::fetchSpecByID($pageID);

        if (!empty($redirectToURI)) {
            $className = 'CBRedirect';
        } else {
            $className = 'CBViewPage';
        }

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
            'className' => $className,
            'classNameForSettings' => 'MDPageSettingsForResponsivePages',
            'frameClassName' => 'MDPageFrame',
            'isPublished' => empty($model->isHidden) || !empty($redirectToURI),
            'publicationTimeStamp' => $timestamp,
            'redirectToURI' => $redirectToURI,
            'title' => $title,
            'URI' => $URI,
        ]);

        /* views */

        if ($className === 'CBViewPage') {
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

            CBView::setSubviews($pageSpec, $subviews);
        }

        /* save */

        if ($pageSpec != $originalPageSpec) {
            CBDB::transaction(function () use ($pageSpec) {
                CBModels::save($pageSpec);
            });
        }
    }
}
