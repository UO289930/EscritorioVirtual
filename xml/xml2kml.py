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

    return raiz.findall(expresionXPath)
    """
    # Recorrido de los elementos del árbol
    for hijo in : # Expresión XPath
        print("\nElemento = " , hijo.tag)
        if hijo.text != None:
            print("Contenido = ", hijo.text.strip('\n')) #strip() elimina los '\n' del string
        else:
            print("Contenido = ", hijo.text)    
        print("Atributos = ", hijo.attrib)

        coordenadas = hijo.attrib
    """

def get_prologo(nombre):
    return '<?xml version="1.0" encoding="UTF-8"?>\n<kml xmlns="http://www.opengis.net/kml/2.2">\n<Document>\n<Placemark>\n<name>'+nombre+'</name>\n<LineString>\n<extrude>1</extrude>\n<tessellate>1</tessellate>\n<coordinates>\n'

def get_epilogo():
    return "</coordinates>\n<altitudeMode>relativeToGround</altitudeMode>\n</LineString>\n<Style id='lineaRoja'>\n<LineStyle>\n<color>#ff0000ff</color>\n<width>5</width>\n</LineStyle>\n</Style>\n</Placemark>\n</Document>\n</kml>"


def generar_kml_rutas(archivoXML):
    coordenadasRuta = getXPath(archivoXML,'.//coordenadasRuta')

    for i in range(1,len(coordenadasRuta)+1):
        kml_name = 'ruta' + str(i) + '.kml'
        kml = open(kml_name,"w")
        kml.write(get_prologo(kml_name))

        coordenadasHito = getXPath(archivoXML,'./ruta['+str(i)+']/hitos/hito/coordenadasHito')

        coordenadas = [coordenadasRuta[i-1]]
        coordenadas.extend(coordenadasHito)

        for coordenada in coordenadas:
            
            kml.write(coordenada.get('longitud'))
            kml.write(',')
            kml.write(coordenada.get('latitud'))
            kml.write(',')
            kml.write(coordenada.get('altitud'))
            kml.write('\n')

        kml.write(get_epilogo())
        kml.close()




def main():
    print(getXPath.__doc__)

    miArchivoXML = input('Introduzca un archivo XML de rutas = ')
    generar_kml_rutas(miArchivoXML)


if __name__ == "__main__":
    main()    

