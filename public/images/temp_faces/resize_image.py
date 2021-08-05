#!C:/Program Files/Python39/python.exe
import sys
import os
import PIL
from PIL import Image, ImageOps

image = sys.argv[1]
filepath = "C:/laragon/www/votingsystem/public/temp_faces/"

fixed_height = 420
image = Image.open(filepath+image)
height_percent = (fixed_height / float(image.size[1]))
width_size = int((float(image.size[0]) * float(height_percent)))
image = image.resize((width_size, fixed_height), PIL.Image.NEAREST)
image = ImageOps.exif_transpose(image)
image.save(filepath+image)
print("True")