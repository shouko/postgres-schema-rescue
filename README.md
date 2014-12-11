Postgres Schema Rebuild
======
Postgres Schema Rebuild is a tool used to help database administrator rebuild a PostgreSQL database with identical schema as the original one, with only access to execute **SELECT** SQL statment.

Unlike MySQL, which has a **SHOW CREATE TABLE** statement built in, the only way to backup the schema of a Postgres database is to use the **pgdump** utility. Since **pgdump** requires direct access to the database, which may not be available in some cases.

# Usage
	php app.php [ TABLE_NAME_AND_PKEYS.json ] [ TABLE_COLUMN_INFO_DIRECTORY ] [ OUTPUT_FILENAME.sql]

# Preparation
 - List all tables in the target database

		SELECT table_schema,table_name
		FROM information_schema.tables
		ORDER BY table_schema,table_name;
	- [How do I list all databases and tables using psql?](http://dba.stackexchange.com/questions/1285/how-do-i-list-all-databases-and-tables-using-psql)


 - Get primary keys of a specific table

		SELECT
		pg_attribute.attname,
		format_type(pg_attribute.atttypid, pg_attribute.atttypmod)
		FROM pg_index, pg_class, pg_attribute
		WHERE
		pg_class.oid = 'TABLENAME'::regclass AND
		indrelid = pg_class.oid AND
		pg_attribute.attrelid = pg_class.oid AND
		pg_attribute.attnum = any(pg_index.indkey)
		AND indisprimary

	- [Retrieve primary key columns - PostgreSQL Wiki](https://wiki.postgresql.org/wiki/Retrieve_primary_key_columns)

	After retrieving the primary keys of all the tables, encode them into a JSON file with an array of primary keys info of each table.


 - Get detailed column info of a specific table

		SELECT * FROM INFORMATION_SCHEMA.COLUMNS
		WHERE table_name = 'TABLENAME';

	- [PostgreSQL "DESCRIBE TABLE"](http://stackoverflow.com/questions/109325/postgresql-describe-table)

		After retrieving the info of columns of a table, encode each table into a JSON file, and name it with table name with suffix of **.json**, place all of them into a directory.