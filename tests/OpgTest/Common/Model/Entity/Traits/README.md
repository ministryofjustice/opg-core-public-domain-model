Trait Tests
-----------

Note stub classes were attempted that only contained the 'trait' required for testing. However, we all had issues with
autoloading from the test directory itself.

Therefore as a short term solution, the test itself will use the trait. For simple traits/tests this is not a problem,
however for the InputFilterTest & Trait this has become somewhat more complicated.

In PHPUnit 3.8, testing traits comes part of it, however as of today it is not stable.