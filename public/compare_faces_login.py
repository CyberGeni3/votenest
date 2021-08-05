#!C:/Program Files/Python39/python.exe
import face_recognition
import sys
import os
import numpy
from os import listdir,path
sys.path.append("C:/laragon/www/votingsystem/public/py/")
from FaceSQL import FaceSQL

fcSQL = FaceSQL()

my_id = sys.argv[1]
image_name = my_id+".jpg"
known_face_encoding = []

try:
    db_image = fcSQL.searchFaceData(my_id)
except:
    print("Database connection error")

# Convert string to numpy ndarray type, that is, matrix
         # Convert to a list
dlist = db_image['encoding'].strip(' ').split(',')
         # Convert str from list to float
dfloat = list(map(float, dlist))
known_image = numpy.array(dfloat)
known_face_encoding.append(known_image)

try:
    # Load the jpg file into numpy arrays
    unknown_image = face_recognition.load_image_file("C:/laragon/www/votingsystem/public/images/login_temp_faces/"+image_name)
except:
    print("file_not_located")
    quit()

# Get the face encodings for each face in each image file
# Since there could be more than one face in each image, it returns a list of encodings.
# But since I know each image only has one face, I only care about the first encoding in each image, so I grab index 0.
try:
    unknown_face_encoding = face_recognition.face_encodings(unknown_image)[0]
except IndexError:
    print("aborting") #no face found in image
    quit()


#encode client_face
    # Convert numpy array type to list
encoding__array_list = unknown_face_encoding.tolist()
         # Convert the elements in the list to a string
encoding_str_list = [str(i) for i in encoding__array_list]
         # Splice the strings in the list
encoding_str = ','.join(encoding_str_list)

    # results is an array of True/False telling if the unknown face matched anyone in the known_faces array
results = face_recognition.compare_faces(known_face_encoding, unknown_face_encoding)
result = "{}".format(results)

if result == '[True]':
    face_distances = face_recognition.face_distance(known_face_encoding, unknown_face_encoding)
    for face_distance in enumerate(face_distances):
        for i, face_distance in enumerate(face_distances):
            fd = "The test image has a distance of {:.2} from known image #{}".format(face_distance, i)
            normal = "{}".format(face_distance < 0.6)
            second_round = "{}".format(face_distance < 0.45)
            if (second_round == "True"):
                print(second_round)
                quit()

else:
    try:
        search_if_face_exist = fcSQL.allFaceData()
    except:
        print("Database connection error")

    face_encodings = []
        # Face feature name collection
    face_names = []
    name_result = []
    for row in search_if_face_exist:
        student_id = row['Student_ID']
        face_encoding_str = row['encoding']

                 #convert dataset into float
        d_list = face_encoding_str.strip(' ').split(',')
                 # Convert str from list to float
        d_float = list(map(float, d_list))
        face_encoding = numpy.array(d_float)
                     # Append the information obtained from the database to the collection
        face_encodings.append(face_encoding)
        face_names.append(student_id)

    for face_result in face_encodings:
        for name in search_if_face_exist:
            to_compare = [face_result]
                #compare faces from database and client-passed image
            compare = face_recognition.compare_faces(to_compare, unknown_face_encoding)
            final_result = "{}".format(compare)
                    # Convert numpy array type to list
            encode_array_list = face_result.tolist()
                     # Convert the elements in the list to a string
            encode_str_list = [str(i) for i in encode_array_list]
                     # Splice the strings in the list
            encode_str = ','.join(encode_str_list)
            if (final_result == "[True]"):            
                if name['encoding'] == encode_str:
                    print(name['Student_ID'])
                    quit()
            else:
                if name['encoding'] != encoding_str and encode_str != encoding_str:
                    print("no_user_yet")
                    quit()
