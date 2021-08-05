#!C:/Program Files/Python39/python.exe
import face_recognition
import sys
import os
import numpy
from os import listdir,path
sys.path.append("C:/laragon/www/votingsystem/public/py/")
from FaceSQL import FaceSQL

fcSql = FaceSQL()

my_id = sys.argv[1]
image_name = my_id+".jpg"

image = face_recognition.load_image_file("C:/laragon/www/votingsystem/public/images/temp_faces/"+image_name)
     # Return the 128-dimensional face encoding of each face in the image
     # There may be multiple faces in the image, remove the face code marked with 0 to indicate the clearest face recognized
try:
    image_face_encoding = face_recognition.face_encodings(image)[0]
except IndexError:
        #aborts if no face is found
    print("aborting")
    quit()

# Convert numpy array type to list
encoding__array_list = image_face_encoding.tolist()
         # Convert the elements in the list to a string
encoding_str_list = [str(i) for i in encoding__array_list]
         # Splice the strings in the list
encoding_str = ','.join(encoding_str_list)

try:
    face_encoding_strs = fcSql.allFaceData()
except:
    print("Database connection error")
        # Face feature coding collection
face_encodings = []
        # Face feature name collection
face_names = []
name_result = []
for row in face_encoding_strs:
    student_id = row['Student_ID']
    face_encoding_str = row['encoding']

             #convert dataset into float
    dlist = face_encoding_str.strip(' ').split(',')
             # Convert str from list to float
    dfloat = list(map(float, dlist))
    face_encoding = numpy.array(dfloat)
                 # Append the information obtained from the database to the collection
    face_encodings.append(face_encoding)
    face_names.append(student_id)

for face_result in face_encodings:
    for name in face_encoding_strs:
            #compare faces from database and client-passed image
        to_compare = [face_result]
        compare = face_recognition.compare_faces(to_compare, image_face_encoding)
        final_result = "{}".format(compare)
        if (final_result == "[True]"):
            # second round of comparison this time by face distance
            face_distances = face_recognition.face_distance(to_compare, image_face_encoding)
            for face_distance in enumerate(face_distances):
                for i, face_distance in enumerate(face_distances):
                    fd = "The test image has a distance of {:.2} from known image #{}".format(face_distance, i)
                    normal = "{}".format(face_distance < 0.6)
                    second_round = "{}".format(face_distance < 0.45)
                if (second_round == "True"):
                            # Convert numpy array type to list
                    encode_array_list = face_result.tolist()
                             # Convert the elements in the list to a string
                    encode_str_list = [str(i) for i in encode_array_list]
                             # Splice the strings in the list
                    encode_str = ','.join(encode_str_list)
                    if name['encoding'] == encode_str:
                        print(name['Student_ID'])
                        quit()

fcSql.saveFaceData(my_id,encoding_str)
print("True")





# Load the jpg files into numpy arrays
#known_image = face_recognition.load_image_file("images/voter_faces/"+image_name)
#unknown_image = face_recognition.load_image_file("images/temp_faces/"+image_name)

# Get the face encodings for each face in each image file
# Since there could be more than one face in each image, it returns a list of encodings.
# But since I know each image only has one face, I only care about the first encoding in each image, so I grab index 0.
#try:
#    known_face_encoding = face_recognition.face_encodings(known_image)[0]
#    unknown_face_encoding = face_recognition.face_encodings(unknown_image)[0]
#except IndexError:
#    print("aborting")
#    quit()

#known_faces = [
#    known_face_encoding
#]

# results is an array of True/False telling if the unknown face matched anyone in the known_faces array
#results = face_recognition.compare_faces(known_faces, unknown_face_encoding)

#print("{}".format(results[0]))
