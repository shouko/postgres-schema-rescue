Postgres Schema Rebuild
======
Postgres Schema Rebuild is a tool used to help database administrator rebuild a PostgreSQL database with identical schema as the original one, with only access to execute **SELECT** SQL statment.

Unlike MySQL, which has a **SHOW CREATE TABLE** statement built in, the only way to backup the schema of a Postgres database is to use the **pgdump** utility. Since **pgdump** requires direct access to the database, which may not be available in some cases.

# Usage
	php app.php [ TABLE_NAME_AND_PKEY.json ] [ TABLE_COLUMN_INFO_DIRECTORY ]