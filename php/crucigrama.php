<?php

    session_start();

    class Record {
        private $server;
        private $user;
        private $pass;
        private $dbname;

        private $name;
        private $surname;
        private $time;
        private $level;

        private $all_records = array();

        public function __construct() {
            $this->server = "localhost";
            $this->user = "DBUSER2023";
            $this->pass = "DBPSWD2023";
            $this->dbname = "records";
        }

        public function check_new_record(){

            $new_record = isset($_SESSION["current_time"]) && isset($_POST["current_time"]) ? !($_POST["current_time"]===$_SESSION["current_time"]) : false;
            $first_time = !isset($_SESSION["current_time"]);

            // Solo guardar resultados si es la primera vez o
            // si es un nuevo record diferente de uno ya mandado
            if (count($_POST)>0 && ($first_time || $new_record)) {
                
                $record = new Record();
                $this->name = $_POST["name"];
                $this->surname = $_POST["surname"];
                $this->time = $_POST["time"];
                $this->level = $_POST["level"];
                $this->save_record();

                $_SESSION["current_time"] = $_POST["current_time"];
            }

            // Solo guardar resultados si ya se rellenó el crucigrama una vez
            if(isset($_SESSION["current_time"])){
                $this->store_results();
            }
        }

        private function save_record(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
            
            if($db->connect_error){
                return;
            }

            $insert = "INSERT INTO registro (user_name, user_surname, user_time, game_level) VALUES (?,?,?,?)";
            $query = $db->prepare($insert);
            $query->bind_param("ssis", $_POST["name"], $_POST["surname"], $_POST["time"], $_POST["level"]);
            $query->execute();

            $query->close();
            $db->close();
        }

        private function store_results(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if($db->connect_error){
                return;
            }
            
            $select = "SELECT * FROM registro ORDER BY user_time asc LIMIT 10";
            $records = $db->query($select);

            if($records->num_rows > 0){
                $n_record = 0;
                while($row = $records->fetch_assoc()){
                    $line = $row["user_name"] ." ". $row["user_surname"] .": ". $row["user_time"] ." segundos en nivel ".$row["game_level"];
                    array_push($this->all_records, $line);
                }
            }

            $records->free();
            $db->close();
        }

        public function print_records(){
            $records = $this->all_records;
            if(count($records) > 0 ){
                echo "  <section data-element='record'>
                            <h3>Mejores juegos recogidos</h3>
                            <ol>";

                foreach ($records as $record) {
                    echo "<li>".$record."</li>";
                }

                echo "</ol></section>";
            }
        }

    }

    const record = new Record();
    record->check_new_record();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <meta name ="author" content ="Sergio Truébano Robles" />
    <meta name ="description" content ="Crucigrama matemático" />
    <meta name ="keywords" content ="juego,crucigrama" />
    <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
    <title>Escritorio Virtual - Juegos</title>

    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css" />
    <link rel="stylesheet" type="text/css" href="../estilo/crucigrama.css" />
    <link rel="icon" href="../multimedia/imagenes/favicon.ico" />

    <!-- link de enlace a javascript y jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="../js/crucigrama.js"></script>
</head>
    
<body>

    <header>
        <h1>Escritorio Virtual</h1>
        <nav>
            <a href="../index.html" title="Índice" accesskey="I" tabindex="1">Inicio</a>
            <a href="../sobremi.html" title="Sobre mi" accesskey="S" tabindex="2">Sobre mi</a>
            <a href="../noticias.html" title="Noticias" accesskey="N" tabindex="3">Noticias</a>
            <a href="../agenda.html" title="Agenda" accesskey="A" tabindex="4">Agenda</a>
            <a href="../meteorologia.html" title="Meteorología" accesskey="M" tabindex="5">Meteorología</a>
            <a href="viajes.php" title="Viajes" accesskey="V" tabindex="6">Viajes</a>
            <a href="../juegos.html" title="Juegos" accesskey="J" tabindex="7">Juegos</a>
           
        </nav>
    </header>

    <section data-element="menu">
        <h2>Menú de juegos</h2>
        <nav>
            <a href="../memoria.html" title="Juego de memoria" accesskey="U" tabindex="8">Juego de memoria</a>
            <a href="../sudoku.html" title="Sudoku" accesskey="K" tabindex="9">Sudoku</a> 
            <a href="crucigrama.php" title="Crucigrama" accesskey="C" tabindex="10">Crucigrama matemático</a>
            <a href="../api.html" title="Reproductor" accesskey="R" tabindex="11">Reproductor de música</a>
            <a href="inventario.php" title="Inventario" accesskey="O" tabindex="12">Inventario de componentes</a>
        </nav>
    </section>
    
    
    <main>
        <article data-element="crucigrama">
            <h2>Crucigrama</h2>

            <section data-element="help">
                <h3>Ayudas</h3>
                <p>
                    ¡Bienvenido/a al Crucigrama Matemático!
                    En este desafiante crucigrama, su tarea es completar cada casilla con el número o signo matemático correcto para que todas las operaciones sean válidas. 
                    Cada pista le llevará a una posición específica en la cuadrícula, y su misión es resolver todas las ecuaciones correctamente.
                </p>
                    
                <p><strong>Lea muy bien las siguientes instrucciones:</strong></p>
                <ul>
                    <li>El orden de las operaciones puede ser de izquierda a derecha, o de derecha a izquierda, y de arriba a abajo, o de abajo a arriba.</li>
                    <li>Los valores ya establecidos no pueden ser cambiados.</li>
                    <li>Los nuevos valores introducidos solo pueden ser de un dígito.</li>
                    <li>Rellene cada casilla con el número o signo (+,-,*,/) adecuado.</li>
                    <li>Preste atención a las valores ya establecidos y asegúrese de que cada operación sea válida en todas las direcciones (horizontal y vertical).</li>
                    <li>Los valores introducidos pueden ser cambiados poniendo otro valor.</li>
                    <li>En teléfonos móviles se necesita seleccionar la casilla y utilizar la botonera que se encuentra debajo del crucigrama para introducir un número.</li>
                    <li>Algunas casillas pueden tener más de una posibilidad correcta, ¡encuentre la solución más adecuada!</li>
                </ul>
            </section>

            <script>
                crucigrama.paintMathword();
                document.addEventListener('keydown', crucigrama.manageEvent.bind(crucigrama));
            </script>
        </article>
        
        <section data-type="botonera">
            <h2>Botonera</h2>
            <button onclick="crucigrama.introduceElement(1)" title="Número 1">1</button>
            <button onclick="crucigrama.introduceElement(2)" title="Número 2">2</button>
            <button onclick="crucigrama.introduceElement(3)" title="Número 3">3</button>
            <button onclick="crucigrama.introduceElement(4)" title="Número 4">4</button>
            <button onclick="crucigrama.introduceElement(5)" title="Número 5">5</button>
            <button onclick="crucigrama.introduceElement(6)" title="Número 6">6</button>
            <button onclick="crucigrama.introduceElement(7)" title="Número 7">7</button>
            <button onclick="crucigrama.introduceElement(8)" title="Número 8">8</button>
            <button onclick="crucigrama.introduceElement(9)" title="Número 9">9</button> 
            <button onclick="crucigrama.introduceElement('*')" title="Signo de multiplicación">*</button>
            <button onclick="crucigrama.introduceElement('+')" title="Signo de suma">+</button>
            <button onclick="crucigrama.introduceElement('-')" title="Signo de resta">-</button>
            <button onclick="crucigrama.introduceElement('/')" title="Signo de división">/</button>
        </section>

        <?php $records = record->print_records(); ?>

    </main>

</body>
</html>