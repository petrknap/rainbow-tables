# Rainbow tables

Implementation of rainbow tables


Plugins
=======

Input / output
---------------

As input for plugin can be used generator or dictionary. Default location of dictionary is in `/dictionary.txt` file.

Default location for output is in `/database.sqlite` file.

CRC32
-----

If you wish to generate rainbow table for CRC32 run `composer run-script crc32-generate`.

MD5
---

If you wish to generate rainbow table for MD5 run `composer run-script md5-generate`.
