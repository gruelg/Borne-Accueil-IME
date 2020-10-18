from imutils import paths
import face_recognition
import pickle
import cv2
import os

print("[INFO] Traitement des images ")
#chargement des differents dossiers
cheminImages = list(paths.list_images("Album"))

NomsAlbum = []
dimensionsVisages = []

for(i,cheminImages) in enumerate(cheminImages):

	print("[INFO] traitement image {}/{}".format(i+1,len(cheminImages)))
	Noms = cheminImages.split(os.path.sep)[-2]
	print(Noms)
	image = cv2.imread(cheminImages)
	rgb = cv2.cvtColor(image, cv2.COLOR_BGR2RGB)
	#localisation des "landmarks" sur la photo analysee
	points = face_recognition.face_locations(rgb, model="hog")
	#les landmarks sont stockées et encodées
	traitement = face_recognition.face_encodings(rgb, points)
	#chaque traitement correspond a un visage
	for dimensions in traitement :
		dimensionsVisages.append(dimensions)
		NomsAlbum.append(Noms)

donnees = {"dimensions" : dimensionsVisages, "Noms ": NomsAlbum}
f= open("StreamVideo/dimensions_file.pickle","wb")
f.write(pickle.dumps(donnees))
f.close()
