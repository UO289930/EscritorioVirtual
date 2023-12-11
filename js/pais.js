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

        const apikey = "&appid=47b790fd0fc41878c80c57c9846132cb";
        const unidades = "&units=metric";
        const lang = "&lang=es";
        const urlQuery = "https://api.openweathermap.org/data/2.5/forecast?lat=" + this.coordenadasCapital.latitud + "&lon=" + this.coordenadasCapital.longitud 
                    + lang + unidades + apikey; 

        $("main").append( $("<section></section>") );
        $("main>section").append( $("<h3></h3>").text("Previsión meteorológica en " + pais.nombre) );

        $.ajax({
            dataType: "json",
            url: urlQuery,
            method: 'GET',
            success: function(datos){

                    const dateOptions = { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric', 
                        hour: 'numeric', 
                        minute: 'numeric', 
                        second: 'numeric'
                    };

                    const firstHour = datos.list[0].dt_txt.split(" ")[1];
                    const filter = datos.list.filter(measure => measure.dt_txt.split(" ")[1]==firstHour);

                    $.each(filter, function(i,weatherItem){
                        const iconURL = "https://openweathermap.org/img/wn/" + weatherItem.weather[0].icon + ".png"

                        $("main>section").append($("<article></article>").attr("data-element", "meteo"));

                        var date = new Date(weatherItem.dt_txt).toLocaleString('es', dateOptions);
                        date = date.charAt(0).toUpperCase() + date.substring(1,date.length);

                        $("main article:last").append($("<h4></h4>").text(date));

                        $("main article:last").append($("<img/>")
                                              .attr("src", iconURL)
                                              .attr("alt", date + " " + weatherItem.weather[0].description));

                        $("main article:last").append($("<ul></ul>"));
                        $("main article:last ul").append($("<li></li>").text("Previsión: "+ weatherItem.weather[0].description));
                        $("main article:last ul").append($("<li></li>").text("Temperatura máxima: "+weatherItem.main.temp_max + "°C"));
                        $("main article:last ul").append($("<li></li>").text("Temperatura mínima: "+weatherItem.main.temp_min + "°C"));
                        $("main article:last ul").append($("<li></li>").text("Humedad: "+weatherItem.main.humidity+"%"));

                        try{
                            $("main article:last ul").append($("<li></li>").text("Cantidad de lluvía: "+weatherItem.rain["3h"] +"mm"));
                        }
                        catch(Error){
                            $("main article:last ul").append($("<li></li>").text("Cantidad de lluvía: 0mm"));
                        }
                    });
                },
            error:function(){
                $("main>section").append($("<p></p>").text("No se ha podido obtener la meteorlogía prevista en " + pais.nombre));
            }
        });
    }

}

const pais = new Pais("Brunei", "Begawan", 445.373);
pais.completarInformacion("Monarquía absolutista",
                            {
                                latitud : 4.247525, 
                                longitud : 114.581275
                            },
                            "Musulmana");

