# Rainbow tables

Implementation of rainbow tables


Hash
====

MD5
---

If you wish to generate rainbow table for MD5 run `composer run-script md5-generate`.
The rainbow table will be stored in SQLite database file.

**Warning**, the `md5-generate` script is infinite loop and you must kill it manually by pressing `ctrl`+`c`.
