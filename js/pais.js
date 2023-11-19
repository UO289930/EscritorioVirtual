"use strict";
class Pais {
    constructor (nombre, capital, poblacion){
        this.nombre = nombre;
        this.capital = capital;
        this.poblacion = poblacion;
        this.formaGobierno = null;
        this.coordenadasCapital = null;
        this.religionMayoritaria = null;
    }
    completarInformacion(formaGobierno, coordenadasCapital, religionMayoritaria) {
        this.formaGobierno = formaGobierno;
        this.coordenadasCapital = coordenadasCapital;
        this.religionMayoritaria = religionMayoritaria;
    }

    getNombre() {
        return this.nombre + "";
    }

    getCapital() {
        return this.capital + "";
    }

    getPoblacion() {
        return this.poblacion;
    }

    getFormaGobierno() {
        return this.formaGobierno;
    }

    getReligionMayoritaria() {
        return this.religionMayoritaria;
    }

    getInformacionPrincipalHTML() {


        return '<h3>'+this.getNombre()+'</h3><p><strong>Capital</strong>: '+this.getCapital()+'</p>';
    }

    getInformacionSecundariaHTML() {
        return '<ul><li>Población: '+ this.getPoblacion() +' personas</li><li>Forma de Gobierno: '+this.getFormaGobierno() 
            +'</li><li>Religión Mayoritaria: '+this.getReligionMayoritaria()+'</li></ul>';
    }

    getCoordenadas(){
        return document.write("<p><strong>Coordenadas</strong>: "+this.coordenadasCapital+"</p>");
    }
}

