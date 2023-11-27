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
    completarInformacion(formaGobierno,coordenadasCapital,religionMayoritaria) {
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
        return '<h3>'+this.getNombre()+'</h3><p>Capital: '+this.getCapital()+'</p>';
    }

    getInformacionSecundariaHTML() {
        return '<ul><li>Población: '+ this.getPoblacion() +' personas</li><li>Forma de Gobierno: '+this.getFormaGobierno() 
            +'</li><li>Religión Mayoritaria: '+this.getReligionMayoritaria()+'</li></ul>';
    }

    getCoordenadas(){
        return document.write("<p>Coordenadas (Latitud, Longitud):  "+this.coordenadasCapital.latitud+", "+ this.coordenadasCapital.longitud +"</p>");
    }

    getMeteorologia(){

        var apikey = "&appid=47b790fd0fc41878c80c57c9846132cb";
        var unidades = "&units=metric";
        var lang = "&lang=es";
        var urlQuery = "http://api.openweathermap.org/data/2.5/forecast?lat=" + this.coordenadasCapital.latitud + "&lon=" + this.coordenadasCapital.longitud 
                    + lang + unidades + apikey; 

        console.log(document)

        $.ajax({
            dataType: "json",
            url: urlQuery,
            method: 'GET',
            success: function(datos){

                    // Por cada día de pronóstico se debe incluir al menos la siguiente información: temperatura
                    // máxima, temperatura mínima, porcentaje de humedad, un icono que represente el tiempo que
                    // va a hacer y la cantidad de lluvia del día.

                    // https://openweathermap.org/img/wn/10d.png

                    const dateOptions = { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric', 
                        hour: 'numeric', 
                        minute: 'numeric', 
                        second: 'numeric'
                    };

                    $("main>section").append($("<h3></h3>").text("Previsión meteorológica en " + pais.nombre));

                    const firstHour = datos.list[0].dt_txt.split(" ")[1];
                    const filter = datos.list.filter(measure => measure.dt_txt.split(" ")[1]==firstHour);

                    $.each(filter, function(i,weatherItem){

                        const iconURL = "https://openweathermap.org/img/wn/" + weatherItem.weather[0].icon + ".png"

                        $("main>section").append($("<article></article>").attr("data-element", "meteo"));

                        var date = new Date(weatherItem.dt_txt).toLocaleString('es', dateOptions);
                        date = date.charAt(0).toUpperCase() + date.substring(1,date.length);

                        $("main article:last").append($("<h4> </h4>").text(date));
                        $("main article:last").append($("<img />")
                                                .attr("src", iconURL)
                                                .attr("alt", date + " " + weatherItem.weather[0].description));
                        $("main article:last").append($("<ul> </ul>"));
                        $("main article:last ul").append($("<li> </li>").text("Previsión: "+ weatherItem.weather[0].description));
                        $("main article:last ul").append($("<li> </li>").text("Temperatura máxima: "+weatherItem.main.temp_max + "°C"));
                        $("main article:last ul").append($("<li> </li>").text("Temperatura mínima: "+weatherItem.main.temp_min + "°C"));
                        $("main article:last ul").append($("<li> </li>").text("Humedad: "+weatherItem.main.humidity+"%"));
                        
                    });
                },
            error:function(){

                }
        });
    }

    crearParrafo(posibleHTML){
        const p = document.createElement("p");
        p.innerHTML = posibleHTML;
        return p;
    }

}

const pais = new Pais("Brunei", "Begawan", 445.373);
pais.completarInformacion("Monarquía absolutista",
                            {
                                latitud : 4.594268,
                                longitud : 114.674853
                            },
                            "Musulmana");

