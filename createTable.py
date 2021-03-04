# referenced mysql official documentation
# https://dev.mysql.com/doc/connector-python/en/connector-python-example-ddl.html
# USE python3 to execute python files
from __future__ import print_function
import mysql.connector
from mysql.connector import errorcode
from getpass import getpass

# state database name
DB_NAME = 'ecs_degreeaudit' # acc 0

# table array with table adding query
TABLES = {}
TABLES['student'] = (
    "CREATE TABLE `student` ("
    "  `netid` varchar(9) NOT NULL,"
    "  `first_name` varchar(16) NOT NULL,"
    "  `last_name` varchar(16) NOT NULL,"
    "  `flowchart` json DEFAULT NULL,"
    "  PRIMARY KEY (`netid`)"
    ") ENGINE=InnoDB") # acc 0

TABLES['course_req'] = (
    "CREATE TABLE `course_req` ("
    "  `course_no` varchar(9) NOT NULL,"
    "  `course_prereq` varchar(64),"
    "  `course_coreq` varchar(64),"
    "  PRIMARY KEY (`course_no`)"
    ") ENGINE=InnoDB") #acc 0

# prompt user to enter username and password
uInput = str(input('Username: '))
pInput = getpass()

# try connecting to the database with username and password given
try:
    cnx = mysql.connector.connect(user=uInput, password=pInput,
                                  host='oitdb521d.utdallas.edu',
                                  port='2443') # acc 1
    cursor = cnx.cursor()
# catch error when failed to connected to the database
except mysql.connector.Error as err:
    # denied access because of username or password
    if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
        print("Something is wrong with your user name or password")
    # no database of such name exist
    elif err.errno == errorcode.ER_BAD_DB_ERROR:
        print("Database does not exist")
    # print other error
    else:
        print(err)
else:
    # connected to database
    print("Connected")

    # create the database above if it does not exist
    def create_database(cursor):
        # execute create database query
        try:
            cursor.execute(
                "CREATE DATABASE {} DEFAULT CHARACTER SET 'utf8'".format(DB_NAME))
        # fail to create database, output error and exit program
        except mysql.connector.Error as err:
            print("Failed creating database: {}".format(err))
            exit(1)

    # use database query
    try:
        cursor.execute("USE {}".format(DB_NAME))
    # handle error code
    except mysql.connector.Error as err:
        print("Database {} does not exists.".format(DB_NAME))
        # handle bad database error
        if err.errno == errorcode.ER_BAD_DB_ERROR:
            # create database
            create_database(cursor)
            print("Database {} created successfully.".format(DB_NAME))
            cnx.database = DB_NAME
        # print other error and exit program
        else:
            print(err)
            exit(1)

    # create tables in the database
    for table_name in TABLES:
        table_description = TABLES[table_name]
        # add tables to database
        try:
            print("Creating table {}: ".format(table_name), end='')
            cursor.execute(table_description)
        # handle error code
        except mysql.connector.Error as err:
            # handle table already exists error
            if err.errno == errorcode.ER_TABLE_EXISTS_ERROR:
                print("already exists.")
            # print other error
            else:
                print(err.msg)
        # print "OK" once all tables are created
        else:
            print("OK")

    # close database connection
    cursor.close()
    cnx.close()
