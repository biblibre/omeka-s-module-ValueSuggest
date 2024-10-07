# Changelog

## [1.10.0+biblibre.1] - 2024-10-07

- Improve IdRef results:
  - Use dismax query parser to avoid syntax error
  - Search in `*_s` field too to boost score of results that match exactly
  - Filter on `recordtype_z` wherever it makes sense (and use fq to benefit
    from Solr cache)
