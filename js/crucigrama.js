"use strict"
class Crucigrama{

    constructor(){
        // Fácil
        this.board = "4,*,.,=,12,#,#,#,5,#,#,*,#,/,#,#,#,*,4,-,.,=,.,#,15,#,.,*,#,=,#,=,#,/,#,=,.,#,3,#,4,*,.,=,20,=,#,#,#,#,#,=,#,#,8,#,9,-,.,=,3,#,.,#,#,-,#,+,#,#,#,*,6,/,.,=,.,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,6,#,8,*,.,=,16";
        // Medio
        // this.board = "12,*,.,=,36,#,#,#,15,#,#,*,#,/,#,#,#,*,.,-,.,=,.,#,55,#,.,*,#,=,#,=,#,/,#,=,.,#,15,#,9,*,.,=,45,=,#,#,#,#,#,=,#,#,72,#,20,-,.,=,11,#,.,#,#,-,#,+,#,#,#,*,56,/,.,=,.,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,12,#,16,*,.,=,32";
        // Difícil
        // this.board = "4,.,.,=,36,#,#,#,25,#,#,*,#,.,#,#,#,.,.,-,.,=,.,#,15,#,.,*,#,=,#,=,#,.,#,=,.,#,18,#,6,*,.,=,30,=,#,#,#,#,#,=,#,#,56,#,9,-,.,=,3,#,.,#,#,*,#,+,#,#,#,*,20,.,.,=,18,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,18,#,24,.,.,=,72";

        this.filas = 11;
        this.columnas = 9;
        this.init_time = null;
        this.end_time = null;
        this.tablero = Array(this.filas);
        this.eraCorrecta = false;
    }

    start(){
        var i = 0;
        var j = 0;

        this.tablero[i] = Array(this.columnas);

        const repTablero = this.board.split(",");

        for (var k=0; k<this.board.length; k++) {
            const valor = repTablero[k];
            if(valor === "."){
                this.tablero[i][j] = 0;
            }else if(valor === "#"){
                this.tablero[i][j] = -1;
            } else{
                this.tablero[i][j] = valor;
            }

            if(++j==this.columnas){
                this.tablero[++i] = Array(this.columnas);
                j = 0;
            }
        }
    }

    paintMathword(){

        for(var i=0; i<this.filas; i++){
            for(var j=0; j<this.columnas; j++){
                const valor = this.tablero[i][j];
                const celda = $("<p> </p>")
                                .attr("data-row", i)
                                .attr("data-column", j);

                if(valor==0){
                    celda.attr("data-state", "init").on("click", () => {
                        var seleccionada = $('p[data-state="clicked"]')
            
                        if(seleccionada!=null && this.eraCorrecta){
                            seleccionada.attr("data-state","correct");
                        } else if(seleccionada!=null){
                            seleccionada.attr("data-state","init");
                        }
            
                        this.eraCorrecta = celda.attr("data-state")==="correct";
                        celda.attr("data-state", "clicked");
                    });
                } else if(valor==-1){
                    celda.attr("data-state", "empty");
                } else{
                    celda.attr("data-state", "blocked").text(valor);
                }

                $("main>article").append(celda);
            }
        }

        this.init_time = new Date();
    }

    anyCellClicked(){
        return $('p[data-state="clicked"]').length===0;
    }

    introduceElement(element){
        const seleccionada = $('p[data-state="clicked"]');

        if(seleccionada.length==0){
            window.alert("Ninguna celda está seleccionada");
            return;
        }

        var expression_row = true;
        var expression_col = true;
        const fila = Number(seleccionada.attr("data-row"));
        const columna = Number(seleccionada.attr("data-column"));
        this.tablero[fila][columna] = element;

        var first_number = null;
        var second_number =null;
        var expression = null;
        var result = null;

        var columnaDelIgual = columna;
        const siguienteEnColumna = this.tablero[fila][columna+1];
        const anteriorEnColumna = this.tablero[fila][columna-1];

        // Si hay expresión horizontal...
        if(!((siguienteEnColumna===-1 || siguienteEnColumna===undefined) && (anteriorEnColumna===-1 || anteriorEnColumna===undefined))){
            
            if((columnaDelIgual==this.columnas-1 || siguienteEnColumna===-1 ) && anteriorEnColumna==="="){
                // Celda seleccionada es la última de la expresión horizontal (= a la izquierda de la celda)
                columnaDelIgual -= 1;
            } else{
                // Celda seleccionada está en un punto intermedio (buscar =)
                while(columnaDelIgual!=this.columnas-1){
                    
                    if(this.tablero[fila][columnaDelIgual]==="="){
                        break;
                    }
                    columnaDelIgual++;
                }
            }
    
            first_number = this.tablero[fila][columnaDelIgual-3];
            second_number = this.tablero[fila][columnaDelIgual-1];
            expression = this.tablero[fila][columnaDelIgual-2];
            result = this.tablero[fila][columnaDelIgual+1];

            // Si todo relleno
            if(first_number!=0 && second_number!=0 && expression!=0 && result!=0 ){

                // Si los resultados no coinciden
                try{
                    if(!(eval([first_number,expression,second_number].join("")) == result)){
                        expression_row = false;
                    }
                } catch(Error){
                    expression_row = false;
                }
                
            }
        } 

        var filaDelIgual = fila;
        const siguienteEnFila = this.tablero[fila+1][columna];
        const filaUndefined = this.tablero[fila-1]===undefined;
        const anteriorEnFila = filaUndefined ? undefined : this.tablero[fila-1][columna]; 

        // Si hay expresión vertical
        if(!((siguienteEnFila===-1 || siguienteEnFila===undefined ) && (anteriorEnFila===-1 || anteriorEnFila===undefined))){
            
            if((filaDelIgual==this.filas-1 || siguienteEnFila===-1 ) && anteriorEnFila==="="){
                // Celda seleccionada es la última de la expresión vertical (= encima de la celda)
                filaDelIgual -= 1;
            } else{
                // Celda seleccionada está en un punto intermedio (buscar =)
                while(filaDelIgual!=this.filas-1){
                    
                    if(this.tablero[filaDelIgual][columna]==="="){
                        break;
                    }
                    filaDelIgual++;
                }
            }
    
            first_number = this.tablero[filaDelIgual-3][columna];
            second_number = this.tablero[filaDelIgual-1][columna];
            expression = this.tablero[filaDelIgual-2][columna];
            result = this.tablero[filaDelIgual+1][columna];

            // Si todo relleno
            if(first_number!=0 && second_number!=0 && expression!=0 && result!=0 ){

                // Si los resultados no coinciden
                try{
                    if(!(eval([first_number,expression,second_number].join("")) == result)){
                        expression_col = false;
                    }
                } catch(Error){
                    expression_col = false;
                }
                
            }
        }

        // Si hay errores
        if(!expression_row || !expression_col){
            this.tablero[fila][columna] = 0;
            seleccionada.text("")
            seleccionada.attr("data-state", "init");
            window.alert("El elemento introducido no es correcto");
            return;
        }
        
        // No hay errores
        seleccionada.text(element);
        seleccionada.attr("data-state", "correct");
        
        if(this.check_win_condition()){
            this.end_time = new Date();
            window.alert("Se ha completado el crucigrama en un tiempo de " + this.calculate_date_difference() + " (horas:minutos:segundos)");
        }

    }

    check_win_condition(){
        var win = true;

        for (let index = 0; index < this.filas; index++) {
            win = win && this.tablero[index].filter(celda => celda===0).length==0;
        }

        return win;
    }

    calculate_date_difference(){
        const milis = this.end_time - this.init_time;
        const horas = Math.floor(milis / 3600000);
        const minutos = Math.floor((milis % 3600000) / 60000);
        const segundos = Math.floor((milis % 60000) / 1000);

        return this.#addZero(horas) + ":" + this.#addZero(minutos) + ":" + this.#addZero(segundos);
    }

    #addZero(valor) {
        return valor < 10 ? "0"+valor : valor;
    }
    
}

const crucigrama = new Crucigrama();
crucigrama.start();