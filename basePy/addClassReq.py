# referenced mysql official documentation
# https://dev.mysql.com/doc/connector-python/en/connector-python-example-ddl.html
# USE python3 to execute python files
from __future__ import print_function
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
    # instructions to use this tool
    print("\nPlease add course number with its corresponding pre/co-requisite as the example shown below."
          "Numbers shown in pre/co-requisite fields are the number of pre/co-requisites need to be met "
          "in order to take the course.\n"
          "Course number: CS3340\n"
          " Prerequisite: 2 CS2305 CS1337\n"
          "  Corequisite: 0\n\n"
          "To stop adding more classes enter END to end.\n")

    while 1 == 1:
        # set
        invalidInput = False
        try:
            # add course mysql query
            add_course = ("INSERT INTO course_req "
                          "(course_no, course_prereq, course_coreq) "
                          "VALUES (%s, %s, %s)")

            # update course mysql query
            update_course = ("UPDATE course_req "
                             "SET course_prereq = %s,"
                             "course_coreq = %s "
                             "WHERE course_no = %s")

            # prompt for course number
            c_no = str(input('Course number: '))
            # if input is 'END' end the service
            if c_no.upper() == "END":
                print("Closing connection")
                break
            # delete the space in between the course prefix and the number. example: CS 3340 to CS3340
            elif ' ' in c_no:
                c_no = c_no.replace(' ', '')
                c_no = c_no.upper()
            # if user inputted nothing to c_no, change invalidInput to true
            if c_no == "":
                invalidInput = True
            # prompt for number of course prerequisites and course number of the prerequisites
            c_prereq = str(input(' Prerequisite: '))
            # if input is 'END' end the service
            if c_prereq.upper() == "END":
                print("Closing connection")
                break
            # prompt for number of course corequisites and course number of the corequisites
            c_coreq = str(input('  Corequisite: '))
            # if input is 'END' end the service
            if c_coreq.upper() == "END":
                print("Closing connection")
                break
            # line break for cleanness
            print()
            # handle invalidInput cases
            # if valid output, commit add course query
            if not invalidInput:
                data_addCourse = (c_no, c_prereq, c_coreq)
                # add user inputs to the query
                cursor.execute(add_course, data_addCourse)
                # commit query
                cnx.commit()
            else:
                print("Invalid input. Please try again.\n")
        # catch error when failed to add course to the database
        except mysql.connector.Error as err:
            # if error number 1062 (key already exist)
            if err.errno == 1062:
                # inform user that the course already exist in database
                print(c_no + " already exists in this table.")
                # ask if user wants to update the course
                anw = str(input('Do you want to update pre/co-req of ' + c_no + '? (Y/N):'))
                # handle Y or N options
                if anw.upper() == 'Y':
                    data_updateCourse = (c_prereq, c_coreq, c_no)
                    cursor.execute(update_course, data_updateCourse)
                    cnx.commit()
                    print(c_no + " updated\n")
                else:
                    print("No modification was made.\n")
            else:
                # output error messages that are not handled above
                print(err.msg + "\n")
        else:
            if not invalidInput:
                print(c_no + " inserted\n")
    # close database connection
    cursor.close()
    cnx.close()
    print("Connection closed")
