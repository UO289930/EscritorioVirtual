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

FLOOR = 350
TEXT_FLOOR = FLOOR + 5
INICIO_X = 15
ESCALA_X = 25
ESCALA_Y = 7
COLOR_FIGURA = 'blue'
COLOR_CONTORNO = 'red'

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

def get_prologo(archivoXML, numeroRuta):
    encabezadoConX0 = '<?xml version="1.0" encoding="UTF-8" ?>\n<svg xmlns="http://www.w3.org/2000/svg" version="2.0">\n<polyline points=\n"'+ get_punto(INICIO_X,FLOOR)
    altitudRuta = getXPath(archivoXML, './ruta['+str(numeroRuta)+']/coordenadasRuta')[0].get('altitud')
    altitudInicio = get_punto(INICIO_X, FLOOR-float(altitudRuta)*ESCALA_Y)
    return encabezadoConX0 + altitudInicio

def get_epilogo():
    return '</svg>'

def get_punto(x,y):
    return '\t' + str(int(x)) + ',' + str(int(y)) + '\n'

def generar_svg_rutas(archivoXML):
    rutas = getXPath(archivoXML,'./ruta')

    for i in range(1,len(rutas)+1):
        svg_name = 'perfil' + str(i) + '.svg'
        svg = open(svg_name,"w")
        svg.write(get_prologo(archivoXML, i))

        coordenadasHito = getXPath(archivoXML,'./ruta['+str(i)+']/hitos/hito/coordenadasHito')

        x = INICIO_X

        lugarInicioTexto = '<text x="'+str(INICIO_X)+'" y="'+str(TEXT_FLOOR)+'" style="writing-mode: tb; glyph-orientation-vertical: 0;">\n'+ getXPath(archivoXML,'./ruta['+str(i)+']/lugarInicio')[0].text +'\n</text>\n'
        textos = [lugarInicioTexto]

        for j in range (len(coordenadasHito)):

            #distancia a este punto desde el anterior
            distanciaHitoAnterior = float(getXPath(archivoXML,'./ruta['+str(i)+']/hitos/hito['+str(j+1)+']/distanciaHitoAnterior')[0].text) * ESCALA_X
            x += distanciaHitoAnterior
            #altitud de la coordenada
            y = coordenadasHito[j].get('altitud')
            
            #texto de este punto
            texto = '<text x="'
            texto += str(x)
            texto +='" y="'+str(TEXT_FLOOR)+'" style="writing-mode: tb; glyph-orientation-vertical: 0;">\n'
            texto += getXPath(archivoXML,'./ruta['+str(i)+']/hitos/hito['+str(j+1)+']/nombreHito')[0].text
            texto += '\n</text>\n'
            textos.append(texto)
            
            #punto
            svg.write(get_punto(x,FLOOR-float(y)*ESCALA_Y))

        # xf
        svg.write(get_punto(x,FLOOR))

        # retorno a x0
        svg.write('\t'+str(INICIO_X)+','+str(FLOOR)+'"\nstyle="fill:'+str(COLOR_FIGURA)+';stroke:'+str(COLOR_CONTORNO)+';stroke-width:4" />\n')

        #textos de cada punto
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

