# xml2svg.py
# # -*- coding: utf-8 -*-
""""
Conversion de archivo de rutas en xml a svg.
Reutilización de código de Juan Manuel Cueva Lovelle

@version 1.4 03/Noviembre/2023
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
    return '<?xml version="1.0" encoding="UTF-8" ?>\n<svg xmlns="http://www.w3.org/2000/svg" version="2.0">\n<polyline points=\n\t"10,160\n'

def get_epilogo():
    return '</svg>'


def generar_svg_rutas(archivoXML):
    rutas = getXPath(archivoXML,'./ruta')

    for i in range(1,len(rutas)+1):
        svg_name = 'perfil' + str(i) + '.svg'
        svg = open(svg_name,"w")
        svg.write(get_prologo(svg_name))

        coordenadasHito = getXPath(archivoXML,'./ruta['+str(i)+']/hitos/hito/coordenadasHito')
        xAnterior = 10

        textos = ['<text x="10" y="165" style="writing-mode: tb; glyph-orientation-vertical: 0;">\nInicio\n</text>\n']

        for j in range (len(coordenadasHito)):

            distanciaHitoAnterior = 0
            if(j!=0):
                distanciaHitoAnterior = float(getXPath(archivoXML,'./ruta['+str(i)+']/hitos/hito['+str(j+1)+']/distanciaHitoAnterior')[0].text)
            else:
                distanciaHitoAnterior = 1

            xAnterior += distanciaHitoAnterior
            altitud = coordenadasHito[j].get('altitud')

            texto = '<text x="'
            texto += str(xAnterior*10)
            texto +='" y="165" style="writing-mode: tb; glyph-orientation-vertical: 0;">\n'
            texto += getXPath(archivoXML,'./ruta['+str(i)+']/hitos/hito['+str(j+1)+']/nombreHito')[0].text
            texto += '\n</text>\n'
            textos.append(texto)
            
            svg.write('\t')
            svg.write(str(xAnterior*10))
            svg.write(',')
            svg.write(str(int(160-float(altitud))))
            svg.write('\n')

        svg.write('\t'+str(xAnterior*10+15)+',160\n')
        svg.write('\t10,160"\nstyle="fill:white;stroke:red;stroke-width:4" />\n')
        textos.append('<text x="'+str(xAnterior*10+15)+'" y="165" style="writing-mode: tb; glyph-orientation-vertical: 0;">\nFinal\n</text>\n')

        leyenda = ''.join(textos)
        svg.write(leyenda)

        svg.write(get_epilogo())
        svg.close()




def main():
    print(getXPath.__doc__)

    miArchivoXML = input('Introduzca un archivo XML de rutas = ')
    generar_svg_rutas(miArchivoXML)


if __name__ == "__main__":
    main()    

