#!/usr/bin/env python
from imutils.video import VideoStream
from imutils.video import FPS
import face_recognition
import imutils
import pickle
import time
import cv2
import os
#fichier servant a analyser les images pour trouver les visages
detecteur = cv2.CascadeClassifier('haarcascade_frontalface_alt2.xml')

fichierDimensions = open("dimensions_file.pickle", "rb")
DimensionsVisages =pickle.loads(fichierDimensions.read())

class VideoCamera(object):
    def __init__(self):

        self.video = cv2.VideoCapture(0)
        self.nomRetour = 'Inconu'
        self.nbImages = 0 ;

    def __del__(self):
        self.video.release()

    def get_image(self):
        entete , image = self.video.read()
        #redefinit la taille de l'image
        image = imutils.resize(image,width=300)
        #le traitement s'effectue sur l'image en noir et blanc
        imageGrise = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        #definition de parametres pour la detection de visage
        rectangles = detecteur.detectMultiScale(imageGrise, scaleFactor=1.1,
    	      minNeighbors=1, minSize=(100,100),
    	      flags = cv2.CASCADE_SCALE_IMAGE)
        #l'ordre des coordonnés du rectangle est dans le mauvais sens
        Rectangle = []
        for (x, y, w, h) in rectangles:
            #(haut, droite, bas, gauche)
            #(gauche, haut), (droite, bas),
            Rectangle = [(y, x + w, y + h, x) ]


        #stocke les caracteristiques des visages dans une variable
        visage_camera = face_recognition.face_encodings(image, Rectangle)
        #tableau des noms connus
        noms = []
        #comparaison de chaque visages avec celui détecté dans l'image
        for visage in visage_camera:
            visages_comparaison = face_recognition.compare_faces(DimensionsVisages["dimensions"],visage)
            nom = "Inconnu"
            if True in visages_comparaison:
            	#enumere le nombre de visages testé pour trouver le nom
                for (i,b) in enumerate(visages_comparaison):
                    if b == True :
                        Comparaison = [i]
                #cherche le nom enregistré dans le fichier .pickle
                for i in Comparaison:
                    nom = DimensionsVisages["Noms "][i]
                noms.append(nom)
        #affiche le contenu de la variable nom au dessus du rectangle
        for ((haut, droite, bas, gauche), nom) in zip(Rectangle, noms):
            cv2.rectangle(image, (gauche, haut), (droite, bas),
    			(0, 255, 0), 2)
            y = haut - 15 if haut - 15 > 15 else haut + 15
            cv2.putText(image, nom, (gauche, y), cv2.FONT_HERSHEY_SIMPLEX,
                    0.75, (0, 255, 0), 2)
        self.nomRetour = noms
        retour , jpg = cv2.imencode('.jpg',image)
        return jpg.tobytes()

    def get_nom(self):
        return self.nomRetour

    def ajout_album(self,nom):
        entete , image = self.video.read()
        dossier = "C:/wamp64/www/IME_Pie/Album/"+nom
        image = imutils.resize(image,width=300)
        #le traitement s'effectue sur l'image en noir et blanc
        imageGrise = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        #definition de parametres pour la detection de visage
        rectangles = detecteur.detectMultiScale(imageGrise, scaleFactor=1.1,
    	      minNeighbors=1, minSize=(100,100),
    	      flags = cv2.CASCADE_SCALE_IMAGE)
        #si un visage est detecté dans l'image
        if(len(rectangles) == 1 ):
            chemin = os.path.sep.join([dossier, "{}.png".format(str( self.nbImages).zfill(5))])
            cv2.imwrite(chemin, image)
            self.nbImages = self.nbImages + 1
        #print(os.listdir())
        Rectangle = []
        for (x, y, w, h) in rectangles:
            #(haut, droite, bas, gauche)
            #(gauche, haut), (droite, bas),
            Rectangle = [(y, x + w, y + h, x) ]
        for (haut, droite, bas, gauche) in Rectangle :
            cv2.rectangle(image, (gauche, haut), (droite, bas),
    			(0, 255, 0), 2)
        #encode l'image en .jpg
        retour, jpg = cv2.imencode('.jpg',image)
        return jpg.tobytes()

    def get_nbImages(self):
        return self.nbImages
