import cv2
import numpy as np
from flask import Flask, request
app = Flask(__name__)

@app.route("/imageSearch",methods=["POST"])
def imageSearch():
	filename = request.form.get("inputImage","")
	typeof = request.form.get("type","")
	return 0

def pest():
	img = cv2.imread(filename,0)
	img = cv2.medianBlur(img,5)

	ret,th1 = cv2.threshold(img,127,255,cv2.THRESH_BINARY)
	th2 = cv2.adaptiveThreshold(img,255,cv2.ADAPTIVE_THRESH_MEAN_C,\
	            cv2.THRESH_BINARY,11,2)
	th3 = cv2.adaptiveThreshold(img,255,cv2.ADAPTIVE_THRESH_GAUSSIAN_C,\
	            cv2.THRESH_BINARY,11,2)

	images = [img, th1, th2, th3]
	th1 = cv2.bitwise_not(th1,th1)
	res = cv2.bitwise_and(img,img, mask= th1)

	cv2.imwrite('pest4.jpg',res)
	for i in xrange(4):
	    cv2.imwrite('pest'+str(i)+'.jpg',images[i])
	return "Hello World!"

@app.route("/diseases",methods=["POST"])
def diseases():
	img = cv2.imread(filename)

	hsv = cv2.cvtColor(img, cv2.COLOR_BGR2HSV)

	h,s,v = cv2.split(hsv)

	lower_green = np.array([50,100,100])
	upper_green = np.array([70,255,255])

    # Threshold the HSV image to get only blue colors
	mask = cv2.inRange(img, lower_green, upper_green)
	#mask = cv2.bitwise_not(mask,mask)
    # Bitwise-AND mask and original image
	res = cv2.bitwise_and(img,img, mask= mask)

	cv2.imwrite('mask.jpg',mask)
	cv2.imwrite('res.jpg',res)
	cv2.imwrite('h.jpg',h)
	cv2.imwrite('s.jpg',s)
	cv2.imwrite('i.jpg',v)
	return "Hello World!"

if __name__ == "__main__":
    app.run()