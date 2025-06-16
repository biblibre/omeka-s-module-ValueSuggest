<?php
namespace ValueSuggest\DataType\IdRef;

use ValueSuggest\DataType\AbstractDataType;
use ValueSuggest\DataType\UpdatableDataTypeInterface;
use ValueSuggest\Suggester\IdRef\IdRefSuggestAll;
use ValueSuggest\Updater\IdRefUpdater;
use ValueSuggest\Updater\UpdaterInterface;

class Idref extends AbstractDataType implements UpdatableDataTypeInterface
{
    protected $idrefName;
    protected $idrefLabel;
    protected array $idrefParams;

    public function setIdrefName($idrefName)
    {
        $this->idrefName = $idrefName;
        return $this;
    }

    public function setIdrefLabel($idrefLabel)
    {
        $this->idrefLabel = $idrefLabel;
        return $this;
    }

    public function setIdrefParams(array $idrefParams)
    {
        $this->idrefParams = $idrefParams;
        return $this;
    }

    public function getSuggester()
    {
        return new IdRefSuggestAll(
            $this->services->get('Omeka\HttpClient'),
            $this->idrefParams
        );
    }

    public function getUpdater(): UpdaterInterface
    {
        $httpClient = $this->services->get('Omeka\HttpClient');
        $logger = $this->services->get('Omeka\Logger');

        return new IdRefUpdater($httpClient, $logger);
    }

    public function getName()
    {
        return $this->idrefName;
    }

    public function getLabel()
    {
        return $this->idrefLabel;
    }
}
