#### User Entities

## Users

A `User` is simply that, someone who uses the system. The domain model provides the basic functionality to persist the
user information into the schema. As we use the ``devise api`` for authentication the persisted data does not contain the
users password information, this field is used as read only for data transfer and authentication via devise, but thereafter
it is not persisted.

A user can belong to a `Team`.

## Teams

`Teams` are a named grouping of assignable entities be they `User`s or other `Team`. Anything that can be assigned to a `User`
can be assigned to a `Team` and then is available to all members of the `Team`.


## NullEntity

This is a temporary entity used by the system when a task is not assigned to anyone. It is never persisted and anything that
has no assignee is reflected under the hood to be assigned to a null entity.

