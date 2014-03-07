[![Build Status](https://travis-ci.org/ministryofjustice/opg-core-public-domain-model.png)](https://travis-ci.org/ministryofjustice/opg-core-public-domain-model)
[![Total Downloads](https://poser.pugx.org/ministryofjustice/opg-core-public-domain-model/downloads.png)](https://packagist.org/packages/ministryofjustice/opg-core-public-domain-model)

# OPG Core Domain Model

A Composer/Packagist library of the model classes for the OPG Core project.

## Rules for a valid LPA

* Applicants must be either a donor or a combination of one or more attorneys.  If there is a donor in the collection, there must be no attorneys.
* There is exactly one donor.
* There is at least one attorney.
* There is at least one certificate provider.  If there are no notified persons, there must be at least two certificate providers.
* There is zero or more notified persons.
* There is exactly one correspondent.  The correspondent may be a person or a company.

## Dependencies

```
> php composer.phar intall
```

## Tests

```
> vendor/bin/phpunit -c tests/phpunit.xml
```



