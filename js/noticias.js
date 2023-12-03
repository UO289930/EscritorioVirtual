"use strict"
class Noticias{

    constructor(){
        window.onload = () =>{
            if (!(window.File && window.FileReader && window.FileList && window.Blob)) {  
                //El navegador no soporta el API File
                $("main").append($("<p> </p>").text("Este navegador NO soporta el API File y este programa puede no funcionar correctamente"));
            }
        }
    }
    
    readInputFile(files){
        const archivo = files[0];
        const tipoTexto = /text.*/;
        const create = this.#createNew;

        if (archivo.type.match(tipoTexto)){

            const lector = new FileReader();
            lector.onload = function (evento) {

                const lineas = lector.result.split("\n");
                lineas.forEach(linea => {
                    const parse = linea.split("_");
                    create(parse[0],parse[1],parse[2],parse[3]);
                });

            }
            lector.readAsText(archivo);

        } else{
            window.alert("El archivo seleccionado debe ser un archivo de texto (.txt)");
        }
    }

    addNew(){
        const titulo = $('input[data-element="titulo"]').val();
        const subtitulo = $('input[data-element="subtitulo"]').val();
        const texto = $('input[data-element="texto"]').val();
        const autor = $('input[data-element="autor"]').val();

        const correctTitulo = this.#checkInput(titulo, "titulo");
        const correctSubtitulo = this.#checkInput(subtitulo, "subtitulo");
        const correctTexto = this.#checkInput(texto, "texto");
        const correctAutor = this.#checkInput(autor, "autor");

        if( correctTitulo && correctSubtitulo && correctTexto && correctAutor){
            this.#createNew(titulo,subtitulo,texto,autor);
            this.#resetInputs();
        }
        else{
            window.alert("Algún campo introducido está vacío");
        }
    }

    #createNew(titulo,subtitulo,texto,autor){
        const hgroup = $("<hgroup> </hgroup>").append($("<h3> </h3>").text(titulo))      // Título
                                              .append($("<p> </p>").text(subtitulo));    // Subtítulo
        const p = $("<p> </p>").text(texto);                                             // Texto
        const footer = $("<footer> </footer>").text("Escrito por ")
                                              .append($("<cite> </cite>").text(autor));  // Autor

        const article = $("<article> </article>").append(hgroup)
                                                 .append(p)
                                                 .append(footer);
        $('main section[data-element="creador"]').before(article);
    }

    #checkInput(valor, nombre){
        if(valor.trim().length==0){
            $('input[data-element="'+nombre+'"]').attr("data-state", "wrong");
            return false;
        } else{
            $('input[data-element="'+nombre+'"]').attr("data-state", "init");
            return true;
        }
    }

    #resetInputs(){
        $('input[data-element="titulo"]').val("");
        $('input[data-element="subtitulo"]').val("");
        $('input[data-element="texto"]').val("");
        $('input[data-element="autor"]').val("");
    }
}

const noticias = new Noticias();