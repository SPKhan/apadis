import cv2
import numpy as np
import json
import os
from flask.ext.cors import CORS, cross_origin
from flask import Flask, request
app = Flask(__name__)
cors = CORS(app)

@app.route("/imageSearch",methods=["POST"])
def imageSearch():
	filename = request.form.get("filename","")
	typeof = request.form.get("type","")
	if typeof == "pest":
		result = pest(filename)
	else:
		result = diseases(filename)
	return result

def pest(filename):
	original_img = cv2.imread(filename)
	img = cv2.imread(filename,0)
	os.remove(filename)

	# Otsu's thresholding after Gaussian filtering
	blur = cv2.GaussianBlur(img,(5,5),0)
	ret,th = cv2.threshold(blur,0,255,cv2.THRESH_BINARY+cv2.THRESH_OTSU)
	
	mask = cv2.bitwise_not(th)

	kernel = np.ones((3,3),np.uint8)
	mask = cv2.morphologyEx(mask, cv2.MORPH_OPEN, kernel)
	
	res = cv2.bitwise_and(img,mask)

	locations = [\
				'../web/results/original_img.jpg',\
				'../web/results/greyscale.jpg',\
				'../web/results/th.jpg',\
				'../web/results/mask.jpg',\
				'../web/results/res.jpg'\
				]
	images = [original_img, img, th, mask, res]
	
	titles = [\
			'Original Image',\
			'Grayscale',\
			'Otsu\'s Thresholding',\
			'Mask',\
			'Result'\
			]
	#data is a json to be converted into html tags
	data = {}
	data['data'] = []
	data['data'].append({'title':'Histogram','location':[]})
	for i in xrange(len(images)):
		cv2.imwrite(locations[i],images[i])
		data['data'].append({'title': titles[i],'location':[locations[i]]})
	
	
	
	html = jsontohtml(data)
	hist = cv2.calcHist([img],[0],None,[256],[0,256])

	histdata = []
	i=0
	for pixel in hist:
		histdata.append([i,int(pixel[0])])
		i+=1

	val = {'histogram':histdata,'html':html}
	
	return json.dumps(val)

def diseases(filename):
	
	name = filename[15:]
	name, extension = name.split(".")
	#data is a json to be converted into html tags
	data = {}
	data['data'] = []
	data['data'].append({'title':'Original Image','location':[filename]})
	data['data'].append({'title':'Histogram','location':[]})

	img2 = cv2.imread(filename, 0)
	img2 = cv2.medianBlur(img2,5)
	ret,th1 = cv2.threshold(img2,127,255,cv2.THRESH_BINARY)
	th2 = cv2.adaptiveThreshold(img2,255,cv2.ADAPTIVE_THRESH_MEAN_C, cv2.THRESH_BINARY,11,2)
	th3 = cv2.adaptiveThreshold(img2,255,cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY,11,2)


	img = cv2.imread(filename)
	bgr = img
	hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)
	h,s,v = cv2.split(hsv)
	b,g,r = cv2.split(bgr)

	red_location = '../web/results/red.jpg'
	blue_location = '../web/results/blue.jpg'
	green_location = '../web/results/green.jpg'

	redmasked_location = '../web/results/red-masked.jpg'
	bluemasked_location = '../web/results/blue-masked.jpg'
	greenmasked_location = '../web/results/green-masked.jpg'

	hue_location = '../web/results/hue.jpg'
	sat_location = '../web/results/sat.jpg'
	val_location = '../web/results/val.jpg'
	mask_location = '../web/results/mask.jpg'
	result_location = '../web/results/result.jpg'

	th_location = '../web/results/th.jpg'


	mask = cv2.inRange(h, 40, 80)
	cv2.bitwise_not(mask, mask)
	
	res = cv2.bitwise_and(img,img, mask= mask)
	redmask = cv2.bitwise_and(r,r, mask= mask)
	greenmask = cv2.bitwise_and(g,g, mask= mask)
	bluemask = cv2.bitwise_and(b,b, mask= mask)


	cv2.imwrite(mask_location,mask)
	cv2.imwrite(result_location,res)
	cv2.imwrite(hue_location,h)
	cv2.imwrite(sat_location,s)
	cv2.imwrite(val_location,v)
	cv2.imwrite(red_location,r)
	cv2.imwrite(green_location,g)
	cv2.imwrite(blue_location,b)
	cv2.imwrite(redmasked_location,redmask)
	cv2.imwrite(greenmasked_location,greenmask)
	cv2.imwrite(bluemasked_location,bluemask)

	cv2.imwrite(th_location,th1)

	data['data'].append({'title':'Threshold','location':[th_location]})
	data['data'].append({'title':'RGB Colorspace','location':[red_location, green_location, blue_location]})
	data['data'].append({'title':'HSV Colorspace','location':[hue_location, sat_location, val_location]})
	data['data'].append({'title':'Mask','location':[mask_location]})
	data['data'].append({'title':'RGB Masked','location':[redmasked_location, greenmasked_location, bluemasked_location]})
	data['data'].append({'title':'Result', 'location':[result_location]})

	html = jsontohtml(data)
	hist = cv2.calcHist([img],[0],None,[256],[0,256])
	
	histdata = []
	i=0
	for pixel in hist:
		histdata.append([i,int(pixel[0])])
		i+=1

	val = {'histogram':histdata,'html':html}
	#os.remove(filename)
	return json.dumps(val)

def jsontohtml(data):
	html = ''
	for data in data['data']:
		html += '<h3>' + data['title'] + '</h3>'
		html += '<div class="row">'
		if len(data['location']) > 0:
			for image in data['location']:
				html += "<img src='" + image + "' class='span4'>"

		else:
			html += '<div id="histogram" style="height:400px;width:600px; "></div>'

		html += '</div>'

	return html

if __name__ == "__main__":
    app.run(debug=True, host = '127.0.0.1')