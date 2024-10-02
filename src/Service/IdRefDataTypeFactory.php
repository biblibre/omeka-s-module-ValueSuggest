<?php
namespace ValueSuggest\Service;

use Interop\Container\ContainerInterface;
use ValueSuggest\DataType\IdRef\IdRef;
use Laminas\ServiceManager\Factory\FactoryInterface;

class IdRefDataTypeFactory implements FactoryInterface
{
    // @url http://documentation.abes.fr/aideidrefdeveloppeur/index.html#presentation
    // Tri par pertinence par défaut.
    protected $types = [
        'valuesuggest:idref:all' => [
            'label' => 'IdRef: All', // @translate
            'params' => [
                'qf' => 'all',
            ],
        ],
        'valuesuggest:idref:person' => [
            'label' => 'IdRef: Person names', // @translate
            'params' => [
                'fq' => 'recordtype_z:a',
                'qf' => 'persname_t persname_s',
            ],
        ],
        'valuesuggest:idref:corporation' => [
            'label' => 'IdRef: Collectivities', // @translate
            'params' => [
                'fq' => 'recordtype_z:b',
                'qf' => 'corpname_t corpname_s',
            ],
        ],
        'valuesuggest:idref:conference' => [
            'label' => 'IdRef: Conferences', // @translate
            'params' => [
                'fq' => 'recordtype_z:s',
                'qf' => 'conference_t conference_s',
            ],
        ],
        'valuesuggest:idref:subject' => [
            'label' => 'IdRef: Subjects', // @translate
            'params' => [
                'qf' => 'subjectheading_t subjectheading_s affcourt_z^20',
            ],
        ],
        'valuesuggest:idref:rameau' => [
            'label' => 'IdRef: Subjects Rameau', // @translate
            'params' => [
                'fq' => 'recordtype_z:j',
                'qf' => 'subjectheading_t subjectheading_s',
            ],
        ],
        'valuesuggest:idref:fmesh' => [
            'label' => 'IdRef: Subjects F-MeSH', // @translate
            'params' => [
                'fq' => 'recordtype_z:t',
                'qf' => 'subjectheading_t subjectheading_s',
            ],
        ],
        'valuesuggest:idref:geo' => [
            'label' => 'IdRef: Geography', // @translate
            'params' => [
                'fq' => 'recordtype_z:c',
                'qf' => 'geogname_t geogname_s',
            ],
        ],
        'valuesuggest:idref:family' => [
            'label' => 'IdRef: Family names', // @translate
            'params' => [
                'fq' => 'recordtype_z:e',
                'qf' => 'famname_t famname_s',
            ],
        ],
        'valuesuggest:idref:title' => [
            'label' => 'IdRef: Uniform titles', // @translate
            'params' => [
                'fq' => 'recordtype_z:f',
                'qf' => 'uniformtitle_t uniformtitle_s',
            ],
        ],
        'valuesuggest:idref:authorTitle' => [
            'label' => 'IdRef: Authors-Titles', // @translate
            'params' => [
                'fq' => 'recordtype_z:h',
                'qf' => 'nametitle_t nametitle_s',
            ],
        ],
        'valuesuggest:idref:trademark' => [
            'label' => 'IdRef: Trademarks', // @translate
            'params' => [
                'fq' => 'recordtype_z:d',
                'qf' => 'trademark_t trademark_s',
            ],
        ],
        'valuesuggest:idref:ppn' => [
            'label' => 'IdRef: PPN id', // @translate
            'params' => [
                'qf' => 'ppn_z',
            ],
        ],
        'valuesuggest:idref:library' => [
            'label' => 'IdRef: Library registry (RCR)', // @translate
            'params' => [
                'fq' => 'recordtype_z:w',
                'qf' => 'rcr_t',
            ],
        ],
    ];

    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $dataType = new IdRef($services);
        return $dataType
            ->setIdrefName($requestedName)
            ->setIdrefLabel($this->types[$requestedName]['label'])
            ->setIdrefParams($this->types[$requestedName]['params']);
    }
}
