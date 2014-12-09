## Opg Core Public Domain Model

* [Brief] (#brief)
* [Legal Entity] (#legal-entity)
* [Cases] (#cases)
* [Actors] (#actors)
* [Users And Teams] (#users-and-teams)
* [Collections] (#collections)
* [System Specific Entities] (#system-specific-entities)

#### Brief

The domain model is used to persist data for the Office of the Public Guardians case maintenance system. We have tried
to logically group all of the areas using either inheritance or traits.

From a very high level the classes interact similar to below

![Alt High level domain](http://g.gravizo.com/g?
  digraph domainmodel {
     assignable -> user;
     assignable -> team;
     legalEntity -> caseItem;
     legalEntity -> person;
     caseItem -> assignable;
     caseItem -> person;
     person -> address;
     person -> phoneNumber;
     donor -> person;
     client -> person;
     attorneyAbstract -> person;
     attorney -> attorneyAbstract;
     deputy -> attorney;
     powerOfAttorney -> caseItem;
     donor -> powerOfAttorney;
     attorney-> powerOfAttorney;
     deputyship -> caseItem;
     client -> deputyship;
     deputy -> deputyship;
     deputy -> assignable;
     notes -> legalEntity;
     warnings ->legalEntity;
     documents->legalEntity;
     tasks -> legalEntity;
     cases -> assignable;
     tasks -> assignable;
     cases -> caseItem;
 }
)

#### Legal Entity

![alt legal entity][legalentity]
[legalentity]: images/legalentity.png

This is the super class for both the `CaseItem` and `Person` types as it contains collections common to both. A `LegalEntity`
can have documents, notes. warnings and tasks attached to them. This also implements the ``toArray()`` method required for
validation across all child types.

#### Cases
![alt Casem Items][caseitems]
[caseitems]: images/caseitems.png

All cases inherit from the parent class of `CaseItem`. This contains the common fields that are used in both `PowerOfAttorney`
and `Deputyship` cases.

* [Power of Attorneys](Cases/PowerOfAttorneys.md)
* [Deputyships](Cases/Deputyships.md)

#### Actors

![alt Person][person]
[person]: images/person.png

All actors inherit from the abstract base `Person` class. This class contains all of the basic attributes we expect to
find on any type of actor. Specialization occurs once this class is inherited. An actor is a type that can perform a specific action upon a `CaseItem`.

* [Donors / Clients](Actors/DonorClient.md)
* [Attorneys](Actors/Attorneys.md)
* [Other Actors] (Actors/OtherActors.md)

#### Users and Teams

![alt assignable][assignable]
[assignable]: images/assignable.png

All `User` types inherit from the `AssignableComposite` base class. Anything that can be assigned uses this interface to
typehint. We do not persist the users password in our domain model as we use an external api service to allow system login and
to persist this data.

* [Users] (Assignable/Users.md#users)
* [Teams] (Assignable/Users.md#teams)
* [Null Entities] (Assignable/Users.md#nullentity)

#### Collections

All of the collections below are array collections of objects attached to a `LegalEntity`. They are used to describe different
collections that can be assigned to the instantiated object.

* [Notes] (Containers/Containers.md#notes)
* [Warnings] (Containers/Containers.md#warnings)
* [Tasks] (Containers/Containers.md#tasks)
* [Documents] (Containers/Containers.md#documents)

The following collections are currently only specific to `CaseItem`

* [Fees] (Containers/Containers.md#fees)
* [Payments] (Containers/Containers.md#payments)

The following collections are currently only specific to `Person`

* [Phone Numbers] (Containers/Containers.md#phone-numbers)
* [Addresses] (Containers/Containers.md#addresses)

#### System Specific Entities

The entities mentioned below are used by the system internals to process data.

* [DDC] (SystemEntities.md#ddc)
* [Events] (SystemEntities.md#events)
* [Queues] (SystemEntities.md#queues)




