[![Build Status](https://travis-ci.org/ministryofjustice/opg-core-public-domain-model.png)](https://travis-ci.org/ministryofjustice/opg-core-public-domain-model)
[![Total Downloads](https://poser.pugx.org/ministryofjustice/opg-core-public-domain-model/downloads.png)](https://packagist.org/packages/ministryofjustice/opg-core-public-domain-model)
[![Coverage Status](https://coveralls.io/repos/ministryofjustice/opg-core-public-domain-model/badge.png)](https://coveralls.io/r/ministryofjustice/opg-core-public-domain-model)
[![Dependency Status](https://www.versioneye.com/user/projects/5319795dec1375cd3900099b/badge.png)](https://www.versioneye.com/user/projects/5319795dec1375cd3900099b)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/ministryofjustice/opg-core-public-domain-model/badges/quality-score.png?s=b00c55af64438259ffed8040ebfa4615451a4064)](https://scrutinizer-ci.com/g/ministryofjustice/opg-core-public-domain-model/)

# OPG Core Domain Model

A Composer/Packagist library of the model classes for the OPG Core project.

## Rules for a valid LPA

* Applicants must be either a donor or a combination of one or more attorneys.  If there is a donor in the collection, there must be no attorneys.
* There is exactly one donor.
* There is at least one attorney.
* There is at least one certificate provider.  If there are no notified persons, there must be at least two certificate providers.
* There are zero or more notified persons.
* There is exactly one correspondent.  The correspondent may be a person or a company.

## Dependencies

```
> php composer.phar install
```

## Tests

```
> vendor/bin/phpunit -c tests/phpunit.xml
```

## Resources

* Github https://github.com/ministryofjustice/opg-core-public-domain-model
* Travis CI https://travis-ci.org/ministryofjustice/opg-core-public-domain-model
* Packagist https://packagist.org/packages/ministryofjustice/opg-core-public-domain-model
* Coveralls https://coveralls.io/r/ministryofjustice/opg-core-public-domain-model
* Version Eye https://www.versioneye.com/user/projects/5319795dec1375cd3900099b
* scrutinizer https://scrutinizer-ci.com/g/ministryofjustice/opg-core-public-domain-model/

