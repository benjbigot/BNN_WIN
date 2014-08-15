from removeD import *
from removeSColor import *
from extractDuration import *
from story import *
def boundaryCreation(a,num):
	#-----------------------------------Duplication removal-------------------------------------------------------
		newphoto=removeD(a)	
	#-------------------------------Remove single color frame-----------------------------------------------------
		removeCo(newphoto,a)
	#-------------------------------Extract Image Time and duration-----------------------------------------------
		extractDuration(newphoto,a)
	#---------------------------------story Boundary detection----------------------------------------------------
		if(num=="1"):
			story()

		
	          


#text_boundary() 