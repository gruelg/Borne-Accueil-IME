from flask import Flask, render_template, Response
from camera import VideoCamera
import cv2 , time , csv
from imutils.video import VideoStream
import numpy as np

app = Flask(__name__)
#definit un chemin pour l'url
@app.route('/Reconnaissance_Faciale')
def index():
    return render_template('Reconnaissance.html')
    #associe un template
@app.route('/ajout_album')
def index2():
    return render_template('Ajout_album.html')

def genCamera(camera):
    i=0
    nbImages = 0
    #le fichier sert a indiquer si la reco est a utiliser
    typecamera_file = open("Bool_reco.txt","r")
    #lis le fichier
    typecamera = typecamera_file.read()
    #.split() stock le contenu du fichier dans une liste
    typecamera = typecamera.split()
    #si la liste est vide la Reco est utilisée
    if not typecamera :
        #ouvre le fichier csv ou sont stocké les noms des visages reconnu
        file = open("tabnom.csv","w")
        #permet d'ecrire dans le fichier csv
        wirter = csv.writer(file)
        #20 images seront traitées pour la reco
        while i<=20:
            #recupere l'image traiter
            image = camera.get_image()
            #recupere le nom du visage reconnu
            nom = camera.get_nom()
            #si aucun nom est retourné
            if not nom:
                #pause de 0.5 secondes
                time.sleep(0.5)
            if(i==0):
                #renvoie une valeur nul pour le traitement
                wirter.writerow("")
            else:
                #ecrit le nom dans le fichier csv
                wirter.writerow(nom)
            i = i+1
            #definit qui l'objet image est une image au format jpeg
            yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + image + b'\r\n\r\n')
        file.close()
    else :
        if(typecamera[0]=="1"):
            while nbImages <= 20 :
                #envoie le nom du dossier ou seront enregistrer les images
                image = camera.ajout_album(typecamera[1])
                #retourne le nombre d'images enregistré
                nbImages = camera.get_nbImages()
                yield (b'--frame\r\n'b'Content-Type: image/jpeg\r\n\r\n' + image + b'\r\n\r\n')
#definit le chemin pour la video en streaming
#le nom "video_feed" est obligatoire definit par Flask

@app.route('/video_feed')
def video_feed():
    return Response(genCamera(VideoCamera()),
                    mimetype='multipart/x-mixed-replace; boundary=frame')
#definit l'adresse IP de l'hote
if __name__ == '__main__':
    app.run(host='127.0.0.1', debug=False)
