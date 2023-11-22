"use strict"
class Sudoku{

    constructor(){
        this.representacionTablero = "3.4.69.5....27...49.2..4....2..85.198.9...2.551.39..6....8..5.32...46....4.75.9.6";
        this.filas = 9;
        this.columnas = 9;
        this.tablero = new Array();
        this.eraCorrecta = false;

        this.start();
    }

    start(){
        var i = 0;
        var j = 0;

        this.tablero[i] = new Array();

        for (var k=0; k<this.representacionTablero.length; k++) {
            const valor = this.representacionTablero.charAt(k);
            if(valor === "."){
                this.tablero[i][j] = 0;
            } else{
                this.tablero[i][j] = Number(valor);
            }

            if(++j==this.columnas){
                this.tablero[++i] = new Array();
                j = 0;
            }
        }
    }

    
    createStructure(){
        const tablero = new Array();

        for(var i=0; i<this.filas; i++){
            for(var j=0; j<this.columnas; j++){
                const valor = this.tablero[i][j];
                const celda = document.createElement("p");

                celda.setAttribute("data-row", i);
                celda.setAttribute("data-column", j);

                if(valor==0){
                    celda.setAttribute("data-state", "init");
                    celda.addEventListener("click", () => {

                        var seleccionada = document.querySelector('p[data-state="clicked"]')

                        if(seleccionada!=null && this.eraCorrecta){
                            seleccionada.setAttribute("data-state","correct");
                        } else if(seleccionada!=null){
                            seleccionada.setAttribute("data-state","init");
                        }

                        this.eraCorrecta = celda.getAttribute("data-state")==="correct";
                        celda.setAttribute("data-state", "clicked");
                    });
                } else{
                    celda.textContent = valor;
                    celda.setAttribute("data-state", "blocked");
                }
                tablero.push(celda);
            }
        }

        return tablero;
    }

    paintSudoku(){
        const tablero = this.createStructure();
        const main = document.querySelector("main");
        tablero.forEach(celda => {
            main.appendChild(celda);
        });
    }

    getClicked(){
        return document.querySelector('p[data-state="clicked"]');
    }

    introduceNumber(number){
        var seleccionada = document.querySelector('p[data-state="clicked"]');

        // No hace falta checkear, si está mal no quedará como correcta
        const fila = Number(seleccionada.getAttribute("data-row"));
        const columna = Number(seleccionada.getAttribute("data-column"));

        // Fila
        const validFila = this.tablero[fila].filter(elemento => elemento===number).length == 0;
        //Columna
        const validColumna = this.tablero.map(fila => fila[columna]).filter(elemento => elemento===number).length == 0;

        if(!validFila && !validColumna){
            window.alert("El número introducido no es correcto para la fila ni la columna correspondiente");
        } else if(!validFila){
            window.alert("El número introducido no es correcto para la fila correspondiente");
        } else if(!validColumna){
            window.alert("El número introducido no es correcto para la columna correspondiente");
        }

        if(!validFila || !validColumna){
            this.#resetCell(fila,columna);
            return;
        }

        //Cuadricula
        const filaInicial = fila - (fila % 3);
        const columnaInicial = columna - (columna % 3);

        for(let i=filaInicial; i<filaInicial+3; i++){
            for(let j=columnaInicial; j<columnaInicial+3; j++){
                if(this.tablero[i][j]===number){
                    window.alert("El número introducido no es correcto para la cuádricula correspondiente");
                    this.#resetCell(fila,columna);
                    return;
                }
            }
        }
        
        this.tablero[fila][columna] = number;
        seleccionada.textContent = number;
        seleccionada.setAttribute("data-state", "correct");

        this.#checkFinish();
    }

    #resetCell(fila,columna){
        var seleccionada = document.querySelector('p[data-state="clicked"]')
        this.tablero[fila][columna] = 0;
        seleccionada.setAttribute("data-state", "init");
        seleccionada.textContent = null;
    }

    #checkFinish(){
        var reduce = this.tablero.filter(celda => celda==0).length;

        if(reduce==0){
            window.alert("!Enhorabuena¡ El juego ha sido completado");
        }
    }
}

const sudoku = new Sudoku();