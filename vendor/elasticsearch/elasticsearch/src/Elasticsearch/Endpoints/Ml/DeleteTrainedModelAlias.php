<?php
/**
 * Elasticsearch PHP client
 *
 * @link      https://github.com/elastic/elasticsearch-php/
 * @copyright Copyright (c) Elasticsearch B.V (https://www.elastic.co)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   https://www.gnu.org/licenses/lgpl-2.1.html GNU Lesser General Public License, Version 2.1 
 * 
 * Licensed to Elasticsearch B.V under one or more agreements.
 * Elasticsearch B.V licenses this file to you under the Apache 2.0 License or
 * the GNU Lesser General Public License, Version 2.1, at your option.
 * See the LICENSE file in the project root for more information.
 */
declare(strict_types = 1);

namespace Elasticsearch\Endpoints\Ml;

use Elasticsearch\Common\Exceptions\RuntimeException;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class DeleteTrainedModelAlias
 * Elasticsearch API name ml.delete_trained_model_alias
 *
 * NOTE: this file is autogenerated using util/GenerateEndpoints.php
 * and Elasticsearch 7.17.0 (bee86328705acaa9a6daede7140defd4d9ec56bd)
 */
class DeleteTrainedModelAlias extends AbstractEndpoint
{
    protected $model_alias;
    protected $model_id;

    public function getURI(): string
    {
        $model_alias = $this->model_alias ?? null;
        $model_id = $this->model_id ?? null;

        if (isset($model_id) && isset($model_alias)) {
            return "/_ml/trained_models/$model_id/model_aliases/$model_alias";
        }
        throw new RuntimeException('Missing parameter for the endpoint ml.delete_trained_model_alias');
    }

    public function getParamWhitelist(): array
    {
        return [];
    }

    public function getMethod(): string
    {
        return 'DELETE';
    }

    public function setModelAlias($model_alias): DeleteTrainedModelAlias
    {
        if (isset($model_alias) !== true) {
            return $this;
        }
        $this->model_alias = $model_alias;

        return $this;
    }

    public function setModelId($model_id): DeleteTrainedModelAlias
    {
        if (isset($model_id) !== true) {
            return $this;
        }
        $this->model_id = $model_id;

        return $this;
    }
}
