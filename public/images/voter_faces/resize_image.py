#!C:/Program Files/Python39/python.exe
import sys
import os
import PIL
from PIL import Image, ImageOps

path = 'C:/laragon/www/votingsystem/public/images/voter_faces/'
images = [file for file in os.listdir( path ) if file.endswith(('jpg'))]
for image in images:
	img = Image.open(path+image)
	img = ImageOps.exif_transpose(img)
	img.thumbnail((600,600))
	img.save(path+image, optimize=True, quality=90)