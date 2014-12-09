## System Specific Entities

#### DDC (Document and Data Capture)

This table is used exclusively by DDC when it is queuing a newly received document for processing. This is to allow batched
create and update documents to be sent to the system without the update documents being rejected due to the creation job being pending.

![alt Document Data Capture][ddc]
[ddc]: images/ddc.png

#### Events

This table is used for an audit trail on the system data. There is a doctrine listener attached that will then compute the changeset
and persist the changes as a json array on ``insert`` and ``update`` events.

![alt Events][events]
[events]: images/events.png

#### Queues

This table is used to generate system tasks on a scheduled basis. This is required by the business rules engine in the backend.

![alt Document Data Capture][queues]
[queues]: images/queues.png
