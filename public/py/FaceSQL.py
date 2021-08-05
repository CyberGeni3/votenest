#!C:/Program Files/Python39/python.exe
import pymysql
 
class FaceSQL:
    def __init__(self):
        self.conn = pymysql.connect(
                         # IP address of the database
            host="127.0.0.1",
                         # Database user name
            user="root",
                         # Database user password
            password="asdasd",
                         # Name of database 
            db="votesystem",
                         # Database port name
            port=3306,
                         # Database encoding method Note that it is utf8
            charset="utf8",

            cursorclass=pymysql.cursors.DictCursor
        )
 
    def processFaceData(self, sqlstr, args=()):
        # Use cursor() method to create a cursor object
        cursor = self.conn.cursor()
        try:
            # Execute sql statement
            cursor.execute(sqlstr, args)
            # Submit to the database to execute
            self.conn.commit()
        except Exception as e:
            # If an error occurs, roll back and print the error message
            self.conn.rollback()
            print(e)
        finally:
            # Close cursor
            cursor.close()
 
    def saveFaceData(self,my_id,encoding_str):
        self.processFaceData("INSERT INTO face(Student_ID, encoding) VALUES(%s,%s)", (my_id, encoding_str))
 
    def updateFaceData(self, my_id, encoding_str):
        self.processFaceData("UPDATE face SET encoding = %s WHERE Student_ID = %s", (encoding_str, my_id))

    def deleteFaceData(self, my_id):
        self.processFaceData("DELETE face WHERE Student_ID = %s", (my_id))
 
    def execute_float_sqlstr(self, sqlstr):
        # Use cursor() method to create a cursor object
        cursor = self.conn.cursor()
        # SQL insert statement
 
        results = []
        try:
            # Execute sql statement
            cursor.execute(sqlstr)
            # Get a list of all records
            results = cursor.fetchall()
        except Exception as e:
            # If an error occurs, roll back and print the error message
            self.conn.rollback()
            print(e)
        finally:
            # Close cursor
            cursor.close()
        return results

    def execute_single_sqlstr(self, sqlstr):
        # Use cursor() method to create a cursor object
        cursor = self.conn.cursor()
        # SQL insert statement
 
        results = []
        try:
            # Execute sql statement
            cursor.execute(sqlstr)
            # Get a list of all records
            results = cursor.fetchone()
        except Exception as e:
            # If an error occurs, roll back and print the error message
            self.conn.rollback()
            print(e)
        finally:
            # Close cursor
            cursor.close()
        return results
 
    def searchFaceData(self, my_id):
        return self.execute_single_sqlstr( "SELECT * FROM face WHERE Student_ID="+my_id)
 
    def allFaceData(self):
        return self.execute_float_sqlstr( "SELECT * FROM face")
 
    def search_info(self,my_id):
        return self.execute_single_sqlstr( "SELECT * FROM voters WHERE student_id="+my_id)