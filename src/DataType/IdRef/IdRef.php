<?php
namespace ValueSuggest\DataType\IdRef;

use ValueSuggest\DataType\AbstractDataType;
use ValueSuggest\Suggester\IdRef\IdRefSuggestAll;

class Idref extends AbstractDataType
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

    public function getName()
    {
        return $this->idrefName;
    }

    public function getLabel()
    {
        return $this->idrefLabel;
    }
}
