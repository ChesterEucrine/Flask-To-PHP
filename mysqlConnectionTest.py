# referenced mysql official documentation
# https://dev.mysql.com/doc/connector-python/en/connector-python-example-connecting.html
# USE python3 to execute python files
from __future__ import print_function
from builtins import input
from builtins import str
import mysql.connector
from mysql.connector import errorcode
from getpass import getpass

# state database name
DB_NAME = 'ecs_degreeaudit'

# prompt user to enter username and password
uInput = str(input('Username: '))
pInput = getpass()

# try connecting to the database with username and password given
try:
    cnx = mysql.connector.connect(user=uInput, password=pInput,
                                  host='oitdb521d.utdallas.edu',
                                  port='2443',
                                  database=DB_NAME)
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
    print("Sucessfully connected to " + DB_NAME)

    # Query data test
    cursor = cnx.cursor()
    query = ("SELECT * FROM ecs_degreeaudit.test_table")
    cursor.execute(query)
    for (id, name) in cursor:
        print("id: {}, name: {}".format(id, name))

    # close database connection
    cursor.close()
    cnx.close()
