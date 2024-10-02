<?php

namespace ValueSuggest\Suggester\IdRef;

use ValueSuggest\Suggester\SuggesterInterface;
use Laminas\Http\Client;
use Laminas\Http\Request;

class IdRefSuggestAll implements SuggesterInterface
{
    const SOLR_URL = 'https://www.idref.fr/Sru/Solr';

    /**
     * @var Client
     */
    protected $client;

    protected array $params = [];

    public function __construct(Client $client, array $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    /**
     * Retrieve suggestions from the IdRef web services API (based on Solr).
     *
     * @see https://www.idref.fr
     * @param string $query
     * @param string $lang
     * @return array
     */
    public function getSuggestions($query, $lang = null)
    {
        $request = new Request();
        $request->setUri(self::SOLR_URL);
        $request->getQuery()->fromArray($this->params + [
            'wt' => 'json',
            'rows' => '30',
            'fl' => 'score,id,ppn_z,affcourt_z,affcourt_r',
            'defType' => 'dismax',
            'mm' => '100%',
            'q' => trim($query),
        ]);

        $response = $this->client->send($request);
        if (!$response->isSuccess()) {
            return [];
        }

        // Parse the JSON response.
        $suggestions = [];
        $results = json_decode($response->getBody(), true);

        if (empty($results['response']['docs'])) {
            return [];
        }

        // Check the result key.
        foreach ($results['response']['docs'] as $result) {
            if (empty($result['ppn_z'])) {
                continue;
            }
            // "affcourt" may be not present in some results (empty words).
            if (isset($result['affcourt_z'])) {
                $value = is_array($result['affcourt_z']) ? reset($result['affcourt_z']) : $result['affcourt_z'];
            } elseif (isset($result['affcourt_r'])) {
                $value = is_array($result['affcourt_r']) ? reset($result['affcourt_r']) : $result['affcourt_r'];
            } else {
                $value = $result['ppn_z'];
            }
            $suggestions[] = [
                'value' => $value,
                'data' => [
                    'uri' => 'https://www.idref.fr/' . $result['ppn_z'],
                    'info' => null,
                ],
            ];
        }

        return $suggestions;
    }
}
