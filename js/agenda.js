"use strict"
class Agenda{

    MIN_MINUTES = 10;

    constructor(){
        this.f1APIurl = "https://ergast.com/api/f1/current"
        this.last_api_call = null;
        this.last_api_result = null;
    }

    mostrarAgenda(temporada){
        if(temporada==null){
            window.alert("Error en la solicitud de la agenda de F1");
            return;
        }

        const carreras = $("Race", temporada);

        $("main article").remove();

        $.each(carreras, function(i,carrera){

            const nombreCarrera = $("RaceName", carrera).text();
            const nombreCircuito = $("CircuitName", carrera).text();
            const latitud= $("Location", carrera).attr("lat");
            const longitud= $("Location", carrera).attr("long");
            const fecha = $("Date:first", carrera).text();
            var hora = $("Time:first", carrera).text();
            // hora = hora.substring(0,hora.length-1);

            $("main").append($("<article> </article>").attr("data-element", "carrera"));
            $("main article:last").append($("<h3> </h3>").text(nombreCarrera));
            $("main article:last").append($("<p> </p>").text("Circuito: " + nombreCircuito));
            $("main article:last").append($("<p> </p>").text("Coordenadas (latitud, longitud) : " + latitud + ", " + longitud));
            $("main article:last").append($("<p> </p>").text("Fecha: " + fecha + " a las " + hora));
            
        });

        
    }

    getAgenda(){
        
        const timePast = this.last_api_call == null ? Infinity : ((new Date() - this.last_api_call) / (60000));
        const mostrar = this.mostrarAgenda;

        if(timePast >= this.MIN_MINUTES){
            $.ajax({
                dataType: "xml",
                url: this.f1APIurl,
                method: 'GET',
                context: this, // Dentro de la función success de ajax, this no es la instancia de Agenda
                success: function(datos){
                    // console.log((new XMLSerializer()).serializeToString(temporada));
                    
                    this.last_api_call = new Date();
                    this.last_api_result = datos;
                    mostrar(datos);
                }
            });
        } else{
            mostrar(this.last_api_result);
        }
    }


}

const agenda = new Agenda();