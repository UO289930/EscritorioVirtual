<?php

    class Record {
        private $server;
        private $user;
        private $pass;
        private $dbname;

        private $name = "";
        private $surname = "";
        private $time = "";
        private $level = "";

        private $all_records = array();

        public function __construct() {
            $this->server = "localhost";
            $this->user = "DBUSER2023";
            $this->pass = "DBPSWD2023";
            $this->dbname = "records";
        }

        public function checkNewRecord(){
            if (count($_POST)>0) {   
                $record = new Record();
                $this->name = $_POST["name"];
                $this->surname = $_POST["surname"];
                $this->time = $_POST["time"];
                $this->level = $_POST["level"];

                $this->saveRecord();
            }
        }

        private function saveRecord(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
            
            if($db->connect_error){
                exit();
            }

            $insert = "INSERT INTO registro (user_name, user_surname, user_time, game_level) VALUES (?,?,?,?)";
            $select = "SELECT * FROM registro ORDER BY user_time LIMIT 10";

            
            $query = $db->prepare($insert);
            $query->bind_param("ssis", $_POST["name"], $_POST["surname"], $_POST["time"], $_POST["level"]);
            
            try{
                $query->execute();
            }
            catch(mysqli_sql_exception $e){ 
                // This means that the page has been reloaded and the data is the same as before
            } 

            $query->close();

            $records = $db->query($select);

            if($records->num_rows > 0){
                $n_record = 0;
                while($row = $records->fetch_assoc()){
                    $line = $row["user_name"] ." ". $row["user_surname"] .": ". $row["user_time"] ." segundos en nivel ".$row["game_level"];
                    array_push($this->all_records, $line);
                }
            }

            $db->close();
        }

        public function getRecords(){
            return $this->all_records;
        }

    }

    const record = new Record();
    record->checkNewRecord();

?>
<!DOCTYPE HTML>
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

    <!--Cabecera-->
    <header>
        <h1>Escritorio Virtual</h1>
        <nav>
            <a href="../index.html" title="Índice" accesskey="I" tabindex="1">Inicio</a>
            <a href="../sobremi.html" title="Sobre mi" accesskey="S" tabindex="2">Sobre mi</a>
            <a href="../noticias.html" title="Noticias" accesskey="N" tabindex="3">Noticias</a>
            <a href="../agenda.html" title="Agenda" accesskey="A" tabindex="4">Agenda</a>
            <a href="../meteorologia.html" title="Meteorología" accesskey="M" tabindex="5">Meteorología</a>
            <a href="../viajes.html" title="Viajes" accesskey="V" tabindex="6">Viajes</a>
            <a href="../juegos.html" title="Juegos" accesskey="J" tabindex="7">Juegos</a>
           
        </nav>

    </header>

    <section data-element="menu">
        <h2>Menú de juegos</h2>
        <nav>
            <a href="../memoria.html" title="Juego de memoria" accesskey="U" tabindex="8">Juego de memoria</a>
            <a href="../sudoku.html" title="Sudoku" accesskey="D" tabindex="9">Sudoku</a> 
            <a href="crucigrama.php" title="Crucigrama" accesskey="C" tabindex="10">Crucigrama matemático</a>
            <a href="../api.html" title="Reproductor" accesskey="R" tabindex="11">Reproductor de música</a>
        </nav>
    </section>
    
    <!-- Datos con el contenidos que aparece en el navegador -->
    <main>
        <article data-element="crucigrama">
            <h2>Crucigrama</h2>

            <script>
                crucigrama.paintMathword();
                document.addEventListener('keydown', (event) => {
                    
                    if (/^[1-9+\-*/]$/.test(event.key)) {
                        if(crucigrama.anyCellClicked()) {
                            window.alert("Ninguna celda está seleccionada");
                        } else{
                            crucigrama.introduceElement(event.key);
                        }
                    }
                });
            </script>
        </article>
        
        <section data-type="botonera">
            <h2>Botonera</h2>
            <button onclick="crucigrama.introduceElement(1)">1</button>
            <button onclick="crucigrama.introduceElement(2)">2</button>
            <button onclick="crucigrama.introduceElement(3)">3</button>
            <button onclick="crucigrama.introduceElement(4)">4</button>
            <button onclick="crucigrama.introduceElement(5)">5</button>
            <button onclick="crucigrama.introduceElement(6)">6</button>
            <button onclick="crucigrama.introduceElement(7)">7</button>
            <button onclick="crucigrama.introduceElement(8)">8</button>
            <button onclick="crucigrama.introduceElement(9)">9</button>
            <button onclick="crucigrama.introduceElement('*')">*</button>
            <button onclick="crucigrama.introduceElement('+')">+</button>
            <button onclick="crucigrama.introduceElement('-')">-</button>
            <button onclick="crucigrama.introduceElement('/')">/</button>
        </section>

        <?php
            $records = record->getRecords();
            if(count($records) > 0 ){
                echo "  <section data-element='record'>
                            <h3>Mejores records recogidos</h3>
                            <ol>";

                foreach ($records as $record) {
                    echo "<li>".$record."</li>";
                }

                echo "</ol></section>";
            }
        ?>

    </main>

</body>
</html>