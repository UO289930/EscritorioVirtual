"use strict"
class Viajes{

    constructor(){
        // navigator.geolocation.getCurrentPosition(funcion exito, funcion error);
        navigator.geolocation.getCurrentPosition(this.#recogePosicion.bind(this), this.#manejarErrores.bind(this));
    }

    #recogePosicion(posicion){
        this.longitud = posicion.coords.longitude; 
        this.latitud = posicion.coords.latitude;  
        // this.precision = posicion.coords.accuracy;
        this.altitud = posicion.coords.altitude;
        // this.precisionAltitud = posicion.coords.altitudeAccuracy;

        this.#crearMapaEstatico();
        this.#crearMapaDinamico();
    }

    #manejarErrores(error){
        var mensaje = null;
        switch(error.code) {
            case error.PERMISSION_DENIED:
                mensaje = "Debe permitir la petición de geolocalización para mostrar todo el contenido de esta página"
                break;
            case error.POSITION_UNAVAILABLE:
                mensaje = "Información de geolocalización no disponible, no se puede mostrar todo el contenido de esta página"
                break;
            case error.TIMEOUT:
                mensaje = "La petición de geolocalización ha caducado, no se puede mostrar todo el contenido de esta página"
                break;
            case error.UNKNOWN_ERROR:
                mensaje = "Se ha producido un error desconocido al intentar reconocer su geolocalización, no se puede mostrar todo el contenido de esta página"
                break;
        }

        const h3 = $("<h3></h3>").text("Error al mostrar los mapas con su ubicación");
        const p = $("<p></p>").text(mensaje);
        const section = $("<section> </section>").append(h3).append(p);

        $('main section[data-element="xml"]').before(section);
    }

    #crearMapaEstatico(){
        //https://api.mapbox.com/styles/v1/mapbox/satellite-v9/static/pin-s+ff0000(-110.7947,37.6535)/-110.7929,37.6549,12,0/500x400?access_token=pk.eyJ1IjoidW8yODk5MzAiLCJhIjoiY2xwancwczF3MDRnMzJqbGI2bnhvaTB4bCJ9.mlFWQ0aSWshJN9dcEBTidg
        const mapBoxAPIUrl = "https://api.mapbox.com/styles/v1/mapbox/satellite-v9/static/"+
                        "pin-s+ff0000("+this.longitud+","+this.latitud+")/"+this.longitud+","+this.latitud+",15,0/500x400?"+
                        "access_token=pk.eyJ1IjoidW8yODk5MzAiLCJhIjoiY2xwancwczF3MDRnMzJqbGI2bnhvaTB4bCJ9.mlFWQ0aSWshJN9dcEBTidg";
        const img = $("<img></img>").attr("src", mapBoxAPIUrl).attr("alt", "Mapa estático de su geolocalización");

        const article = $("<article></article>");
        const h3 = $("<h3></h3>").text("Mapa estático con su posición actual");
        article.append(h3);
        article.append(img);
        $('main section[data-element="xml"]').before(article);

    }

    #crearMapaDinamico(){
        const containerMapa = $("<article></article>");
        const h3 = $("<h3></h3>").text("Mapa dínamico con su posición actual");
        const mapa = $("<article></article>").attr("id", "mapaPosicion").attr("data-element","mapaPosicion");

        containerMapa.append(h3);
        containerMapa.append(mapa);
        $('main section[data-element="xml"]').before(containerMapa);

        mapboxgl.accessToken = "pk.eyJ1IjoidW8yODk5MzAiLCJhIjoiY2xwancwczF3MDRnMzJqbGI2bnhvaTB4bCJ9.mlFWQ0aSWshJN9dcEBTidg";
        const map = new mapboxgl.Map({
            container: "mapaPosicion", // id
            style: "mapbox://styles/mapbox/satellite-v9", // estilo URL
            center: [this.longitud, this.latitud], // coordenadas
            zoom: 15, // zoom inicial
        });

        new mapboxgl.Marker({
            color: "#FF0000" // Código de color hexadecimal para rojo
        })
        .setLngLat([this.longitud, this.latitud])
        .addTo(map);

        map.addControl(new mapboxgl.NavigationControl());
    }

    parseInputFile(files){
        const archivo = files[0];
        const tipoTexto = "text/xml";

        if (archivo.type!=tipoTexto){
            window.alert("El archivo seleccionado debe ser un archivo de texto XML (.xml)");
            return;
        } 

        const lector = new FileReader();
        lector.onload = function (evento) {
            const xml = lector.result;

            $.each($("ruta", xml), (i,ruta)=>{

                // Sección
                const section = $("<section></section>").attr("data-element", "rutas");
                // Titulo
                const titulo = $("<h4></h4>").text( "Ruta Nº" + (i+1) + ": " +  $("nombreRuta",ruta).text() );
                
                const informacion = $("<ul></ul>");
                // Ruta
                informacion.append( $("<li></li>").text($("descripcionRuta",ruta).text()));
                informacion.append( $("<li></li>").text($("adecuado",ruta).text()) );
                informacion.append( $("<li></li>").text("Tipo de ruta: " + ruta.getAttribute("tipo")) );
                informacion.append( $("<li></li>").text("Medio de la ruta: " + ruta.getAttribute("medio")) );
                informacion.append( $("<li></li>").text("Lugar de inicio: " +  $("lugarInicio",ruta).text())
                                        .append( $("<ul></ul>")
                                            .append( $("<li></li>").text("Direccion del lugar de inicio: " + $("direccionInicio",ruta).text()) )
                                            .append( $("<li></li>").text("Coordenadas del lugar de inicio (latitud, longitud, altitud): " 
                                                                            + $("coordenadasRuta",ruta).attr("latitud") + ", "
                                                                            + $("coordenadasRuta",ruta).attr("longitud") + ", "
                                                                            + $("coordenadasRuta",ruta).attr("altitud")) ) ) );
                informacion.append( $("<li></li>").text("Recomendación: " + $("recomendacion",ruta).text()) );

                // Hitos de ruta
                $.each($("hito", ruta), (j,hito) =>{
                    const hitoJQ = $("<li></li>").text("Hito " +(j+1)+ ": " + $("nombreHito",hito).text());
                    const descrip = $("<ul></ul>")
                                        .append( $("<li></li>").text("Descripción del hito: " + $("descripcionHito",hito).text()) ) 
                                        .append( $("<li></li>").text("Coordenadas del hito (latitud, longitud, altitud): " 
                                                                        + $("coordenadasHito",hito).attr("latitud") + ", "
                                                                        + $("coordenadasHito",hito).attr("longitud") + ", "
                                                                        + $("coordenadasHito",hito).attr("altitud")) ) 
                                        .append(  $("<li></li>").text("Distancia a anterior hito: " + $("distanciaHitoAnterior ",hito).text() 
                                                                                            + $("distanciaHitoAnterior ",hito).attr("unidades")) );
                    hitoJQ.append(descrip);
                    informacion.append(hitoJQ);
                });

                // Referencias
                const referencias = $("<li></li>").text("Referencias")
                const referenciasLista = $("<ul></ul>");
                referencias.append(referenciasLista);
                $.each($("referencia", ruta), (j,ref) =>{
                    referenciasLista.append( $("<li></li>")
                                            .append( $("<a></a>").text(ref.innerHTML)
                                                        .attr("href", ref.innerHTML)
                                                        .attr("title", "Referencia " + (j+1) + " con información extra sobre la ruta" ) ) );
                });
                informacion.append(referencias)

                informacion.append($("<li></li>").text("Álbum de fotos"));

                // Añadir titulo y lista a sección
                section.append(titulo);
                section.append(informacion);

                // Fotos al final
                $.each($("foto", ruta), (j,foto) => {
                    section.append( $("<img></img>").attr("src", foto.innerHTML ).attr("alt", "Foto " + (j+1) + " relaciaonada con un hito de esta ruta") );
                });

                // A html   
                $('main section[data-element="xml"]').append(section);
            });
        }
        lector.readAsText(archivo);
    }

    parseInputKmlFiles(files){
        // Comprobación de archivos
        const final = ".kml";
        for(let i=0; i<files.length; i++){
            if(!files[i].name.endsWith(final)){
                window.alert("Todos los archivos deben ser de cartografía (.kml)");
                return;
            }
        }

        const id = "mapaRutas";

        const containerMapa = $("<article></article>");
        const h4 = $("<h4></h4>").text("Mapa dínamico con rutas");
        const mapa = $("<article></article>").attr("id", id).attr("data-element", id);
        containerMapa.append(h4);
        containerMapa.append(mapa);
        $('main section[data-element="kml"]').append(containerMapa);

        this.#crearMapaRutas(files, id);
    }

    #crearMapaRutas(files, id){
        //Mapa
        mapboxgl.accessToken = "pk.eyJ1IjoidW8yODk5MzAiLCJhIjoiY2xwancwczF3MDRnMzJqbGI2bnhvaTB4bCJ9.mlFWQ0aSWshJN9dcEBTidg";
        const map = new mapboxgl.Map({
            container: id,                                  // id
            style: "mapbox://styles/mapbox/satellite-v9",   // estilo URL
            coordenadas : [114.900830, 4.646971],           // long,lat de un punto central a todas las rutas
            zoom: 10                                        // zoom inicial  
        });
        map.addControl(new mapboxgl.NavigationControl());

        var k = 0;
        // Rutas
        for(let i=0; i<files.length; i++){
            const lector = new FileReader();
            lector.onload = function (evento) {
                const kml = lector.result;
                const coordenadas = [];
                const lineas = $("coordinates",kml).text().trim().split("\n");

                for(let j=0; j<lineas.length; j++){
                    const coords = lineas[j].split(","); 
                    coordenadas.push([coords[0], coords[1]]); // Longitud y latitud (no hace falta altitud)
                }

                // Esperar a que el estilo este aplicado al mapa antes de añadirle capas
                map.on("idle", function(){  
                    map.addLayer({  
                        id: id + k++,       // Cada capa necesita un id diferente
                        type: "line",
                        source: {
                            type: "geojson",
                            data: {
                                type: "Feature",
                                properties: {},
                                geometry: {
                                    type: "LineString",
                                    coordinates: coordenadas,
                                },
                            },
                        },
                        layout: {
                            "line-join": "round",
                            "line-cap": "round",
                        },
                        paint: {
                            "line-color": "#FF0000",
                            "line-width": 4,
                        },
                    });
                });
            };
            lector.readAsText(files[i]);
        }
    }

    parseInputSvgFiles(files){
        // Comprobación de archivos
        const final = ".svg";
        for(let i=0; i<files.length; i++){
            if(!files[i].name.endsWith(final)){
                window.alert("Todos los archivos deben ser gráficos vectoriales escalables (.svg)");
                return;
            }
        }

        this.#creaSvgs(files);
    }

    #creaSvgs(files){

        $('main section[data-element="svg"]').remove( $('main section[data-element="svg"] h4') );
        $('main section[data-element="svg"]').append( $("<h4></h4>").text("Altimetría de las rutas") );
        for(let i=0; i<files.length; i++){
            const lector = new FileReader();

            lector.onload = function (evento) { 

                const svgTxt = lector.result;
                const svg = $("<svg> </svg>").attr("width", "500").attr("height","1000")
                                             .text("Su navegador no soprta archivos SVG");
                
                svg.append($("<polyline> </polyline>").attr("points", $("polyline", svgTxt).attr("points"))
                                                      .attr("style", $("polyline", svgTxt).attr("style")));
                $.each($("text", svgTxt), (i,text) => {
                    const newText = $("<text> </text>").attr("x", text.getAttribute("x"))
                                                     .attr("y", text.getAttribute("y"))
                                                     .attr("style", text.getAttribute("style"))
                                                     .text(text.innerHTML);
                    svg.append(newText);                                 
                });

                $('main section[data-element="svg"]').append(svg);
            }

            lector.readAsText(files[i]);
        }

    }

}

const viajes = new Viajes();