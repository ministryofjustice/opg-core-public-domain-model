## Other Actors

#### Certificate Provider

`CertificateProviders` are required by a Power of Attorney type of case, the provide specific validation of conditions.

![alt Certificate Provider][certprov]

#### Correspondent

`Correspondents` are a type of actor that recieves any correspondence regarding the case and it's progress.

![alt Correspondent][correspondent]

#### Non Case Contact/Fee Payer

`NonCaseContacts` and `FeePayers` are actors that do not have any cases directly assigned to them but may be used by the
 system prior to a case being lodged. Note the `FeePayer` currently is attached to a case, but this logic is due to change as
 the business has requested that this become a collection of any actor type.

![alt noncasecontact][noncasecontact]

#### Notified Person/Attorney/Relative/Donor

`NotifiedPerson`, `NotifiedAttorney`, `PersonNotifyDonor` and `NotifiedRelatives` are all actors that will receive notification when a `Power of Attorney`
is registered.

![alt notifiedpersons][notifiedpersons]

[certprov]: ../images/certificate-provider.png
[correspondent]: ../images/correspondent.png
[noncasecontact]: ../images/non-case-contact.png
[notifiedpersons]: ../images/notified-persons.png
