<?php

final class MDTopic {

    /**
     * @param model $spec
     *
     * @return ?model
     */
    static function CBModel_build(stdClass $spec): ?stdClass {
        return (object)[
            'content' => CBModel::valueToString($spec, 'content'),
            'description' => CBModel::valueToString($spec, 'description'),
            'isHidden' => CBModel::valueToBool($spec, 'isHidden'),
            'moniker' => trim(CBModel::valueToString($spec, 'moniker')),
            'redirectToURI' => CBConvert::stringToURI(CBModel::valueToString($spec, 'redirectToURI')),
            'sort' => CBModel::valueAsInt($spec, 'sort'),
            'URI' => CBConvert::stringToURI(CBModel::valueToString($spec, 'URI')),
        ];
    }

    /**
     * @param model $spec
     *
     * @return ?ID
     */
    static function CBModel_toID(stdClass $spec): ?string {
        $moniker = trim(CBModel::valueToString($spec, 'moniker'));

        if (empty($moniker)) {
            return null;
        } else {
            return sha1("MDTopic {$moniker}");
        }
    }

    /**
     * @param [model] $models
     *
     * @return void
     */
    static function CBModels_willSave(array $models): void {
        $IDs = array_map(function ($model) {
            return $model->ID;
        }, $models);

        CBTasks2::restart('MDTopicPageUpdateTask', $IDs, /* priority */ 75);
        MDMainMenuUpdateTask::restart();
    }
}
