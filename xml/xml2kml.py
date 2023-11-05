# xml2kml.py
# # -*- coding: utf-8 -*-
""""
Conversion de archivo de rutas en xml a kml.
Reutilización de código de Juan Manuel Cueva Lovelle

@version 1.3 01/Noviembre/2023
@author: Juan Manuel Cueva Lovelle. Universidad de Oviedo
@author: Sergio Truébano Robles. Universidad de Oviedo
"""

import xml.etree.ElementTree as ET

def getXPath(archivoXML, expresionXPath):
    """Función verXPath(archivoXML, expresionXPath)
    Retorna el nodo correspondiente de una expresión XPath de un archivo XML
    """
    try:
        
        arbol = ET.parse(archivoXML)
        
    except IOError:
        print ('No se encuentra el archivo ', archivoXML)
        exit()
        
    except ET.ParseError:
        print("Error procesando en el archivo XML = ", archivoXML)
        exit()
       
    raiz = arbol.getroot()

    coordenadas = None
    
    return raiz.findall(expresionXPath)

    # Recorrido de los elementos del árbol
    for hijo in : # Expresión XPath
        print("\nElemento = " , hijo.tag)
        if hijo.text != None:
            print("Contenido = ", hijo.text.strip('\n')) #strip() elimina los '\n' del string
        else:
            print("Contenido = ", hijo.text)    
        print("Atributos = ", hijo.attrib)

        coordenadas = hijo.attrib

def generarKmlRutas(archivoXML):
    rutas = len(getXPath(archivoXML, './ruta'))  # numero de rutas

    for i in range(1,rutas+1):
        kml_name = 'ruta' + i + '.kml'

        coordenadas = []
        coordenadasRuta = getXPath('./ruta['+i+']/coordenadasRuta')
        coordenadasRuta.split(',')

        hitos = len(getXPath('./ruta['+i+']/hitos/hito'))


        

def main():
    print(getXPath.__doc__)
    
    miArchivoXML = input('Introduzca un archivo XML = ')
    
    generarKmlRutas()




if __name__ == "__main__":
    main()    

