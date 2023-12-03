"use strict"
class Fondo{

    constructor(nombrePais, nombreCapital, coordenadas){
        this.nombrePais = nombrePais;
        this.nombreCapital = nombreCapital;
        this.coordenadas = coordenadas;
    }

    setFondo(){
        // API Privada
        var flickrAPI = "https://api.flickr.com/services/rest/?method=flickr.photos.search";
        $.getJSON(flickrAPI, 
                {
                    api_key: "49cbf95f9fa6eeaed933058baa0a8d88",
                    // tags: this.nombrePais + "," + this.nombreCapital,
                    // tagmode: "any",
                    // geo_context : 2, // Outdoors : no sale ninguna foto
                    lat: this.coordenadas.latitud,
                    lon: this.coordenadas.longitud,
                    format: "json",
                    nojsoncallback : 1
                })
            .done(function(data){
                // Si no la respuesta no da fotos, no se cambia el fondo
                if(data.photos.photo.length==0){
                    return;
                }
                //https://live.staticflickr.com/{server-id}/{id}_{secret}_{size-suffix}.jpg
                // b es 1024 px sin secreto
                var dato = data.photos.photo[Number.parseInt(Math.random()*data.photos.photo.length)];
                var url = "https://live.staticflickr.com/" + dato.server +"/"+ dato.id +"_"+ dato.secret + "_b.jpg";

                $("body").css("background-image","url("+ url +")")
                         .css("background-size", "cover");
            });

    }

}