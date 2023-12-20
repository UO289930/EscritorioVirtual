<!DOCTYPE HTML>
<html lang="es"><head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8">
    <meta name="author" content="Sergio Truébano Robles">
    <meta name="description" content="Crucigrama matemático">
    <meta name="keywords" content="juego,crucigrama">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escritorio Virtual - Juegos</title>

    <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css">
    <link rel="stylesheet" type="text/css" href="../estilo/crucigrama.css">
    <link rel="icon" href="../multimedia/imagenes/favicon.ico">

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
            <a href="../sudoku.html" title="Sudoku" accesskey="O" tabindex="9">Sudoku</a> 
            <a href="crucigrama.php" title="Crucigrama" accesskey="C" tabindex="10">Crucigrama matemático</a>
            <a href="../api.html" title="Reproductor" accesskey="P" tabindex="11">Reproductor de música</a>
            <a href="inventario.php" title="Inventario" accesskey="T" tabindex="12">Inventario de componentes</a>
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
                    <li>Rellene cada casilla con el número o signo adecuado.</li>
                    <li>Preste atención a las valores ya establecidos y asegúrese de que cada operación sea válida en todas las direcciones (horizontal y vertical).</li>
                    <li>Los valores introducidos pueden ser cambiados poniendo otro valor.</li>
                    <li>En teléfonos móviles se necesita seleccionar la casilla y utilizar la botonera que se encuentra debajo del crucigrama para introducir un número.</li>
                    <li>Algunas casillas pueden tener más de una posibilidad correcta, ¡encuentre la solución más adecuada!</li>
                </ul>
            </section><p data-row="10" data-column="8" data-state="blocked">16</p><p data-row="10" data-column="7" data-state="blocked">=</p><p data-row="10" data-column="6" data-state="correct">2</p><p data-row="10" data-column="5" data-state="blocked">*</p><p data-row="10" data-column="4" data-state="blocked">8</p><p data-row="10" data-column="3" data-state="empty"> </p><p data-row="10" data-column="2" data-state="blocked">6</p><p data-row="10" data-column="1" data-state="empty"> </p><p data-row="10" data-column="0" data-state="empty"> </p><p data-row="9" data-column="8" data-state="blocked">=</p><p data-row="9" data-column="7" data-state="empty"> </p><p data-row="9" data-column="6" data-state="empty"> </p><p data-row="9" data-column="5" data-state="empty"> </p><p data-row="9" data-column="4" data-state="blocked">=</p><p data-row="9" data-column="3" data-state="empty"> </p><p data-row="9" data-column="2" data-state="blocked">=</p><p data-row="9" data-column="1" data-state="empty"> </p><p data-row="9" data-column="0" data-state="empty"> </p><p data-row="8" data-column="8" data-state="correct">4</p><p data-row="8" data-column="7" data-state="empty"> </p><p data-row="8" data-column="6" data-state="empty"> </p><p data-row="8" data-column="5" data-state="empty"> </p><p data-row="8" data-column="4" data-state="correct">2</p><p data-row="8" data-column="3" data-state="blocked">=</p><p data-row="8" data-column="2" data-state="correct">3</p><p data-row="8" data-column="1" data-state="blocked">/</p><p data-row="8" data-column="0" data-state="blocked">6</p><p data-row="7" data-column="8" data-state="blocked">*</p><p data-row="7" data-column="7" data-state="empty"> </p><p data-row="7" data-column="6" data-state="empty"> </p><p data-row="7" data-column="5" data-state="empty"> </p><p data-row="7" data-column="4" data-state="blocked">+</p><p data-row="7" data-column="3" data-state="empty"> </p><p data-row="7" data-column="2" data-state="blocked">-</p><p data-row="7" data-column="1" data-state="empty"> </p><p data-row="7" data-column="0" data-state="empty"> </p><p data-row="6" data-column="8" data-state="correct">4</p><p data-row="6" data-column="7" data-state="empty"> </p><p data-row="6" data-column="6" data-state="blocked">3</p><p data-row="6" data-column="5" data-state="blocked">=</p><p data-row="6" data-column="4" data-state="correct">6</p><p data-row="6" data-column="3" data-state="blocked">-</p><p data-row="6" data-column="2" data-state="blocked">9</p><p data-row="6" data-column="1" data-state="empty"> </p><p data-row="6" data-column="0" data-state="blocked">8</p><p data-row="5" data-column="8" data-state="empty"> </p><p data-row="5" data-column="7" data-state="empty"> </p><p data-row="5" data-column="6" data-state="blocked">=</p><p data-row="5" data-column="5" data-state="empty"> </p><p data-row="5" data-column="4" data-state="empty"> </p><p data-row="5" data-column="3" data-state="empty"> </p><p data-row="5" data-column="2" data-state="empty"> </p><p data-row="5" data-column="1" data-state="empty"> </p><p data-row="5" data-column="0" data-state="blocked">=</p><p data-row="4" data-column="8" data-state="blocked">20</p><p data-row="4" data-column="7" data-state="blocked">=</p><p data-row="4" data-column="6" data-state="correct">5</p><p data-row="4" data-column="5" data-state="blocked">*</p><p data-row="4" data-column="4" data-state="blocked">4</p><p data-row="4" data-column="3" data-state="empty"> </p><p data-row="4" data-column="2" data-state="blocked">3</p><p data-row="4" data-column="1" data-state="empty"> </p><p data-row="4" data-column="0" data-state="correct">2</p><p data-row="3" data-column="8" data-state="blocked">=</p><p data-row="3" data-column="7" data-state="empty"> </p><p data-row="3" data-column="6" data-state="blocked">/</p><p data-row="3" data-column="5" data-state="empty"> </p><p data-row="3" data-column="4" data-state="blocked">=</p><p data-row="3" data-column="3" data-state="empty"> </p><p data-row="3" data-column="2" data-state="blocked">=</p><p data-row="3" data-column="1" data-state="empty"> </p><p data-row="3" data-column="0" data-state="blocked">*</p><p data-row="2" data-column="8" data-state="correct">4</p><p data-row="2" data-column="7" data-state="empty"> </p><p data-row="2" data-column="6" data-state="blocked">15</p><p data-row="2" data-column="5" data-state="empty"> </p><p data-row="2" data-column="4" data-state="correct">3</p><p data-row="2" data-column="3" data-state="blocked">=</p><p data-row="2" data-column="2" data-state="correct">1</p><p data-row="2" data-column="1" data-state="blocked">-</p><p data-row="2" data-column="0" data-state="blocked">4</p><p data-row="1" data-column="8" data-state="blocked">*</p><p data-row="1" data-column="7" data-state="empty"> </p><p data-row="1" data-column="6" data-state="empty"> </p><p data-row="1" data-column="5" data-state="empty"> </p><p data-row="1" data-column="4" data-state="blocked">/</p><p data-row="1" data-column="3" data-state="empty"> </p><p data-row="1" data-column="2" data-state="blocked">*</p><p data-row="1" data-column="1" data-state="empty"> </p><p data-row="1" data-column="0" data-state="empty"> </p><p data-row="0" data-column="8" data-state="blocked">5</p><p data-row="0" data-column="7" data-state="empty"> </p><p data-row="0" data-column="6" data-state="empty"> </p><p data-row="0" data-column="5" data-state="empty"> </p><p data-row="0" data-column="4" data-state="blocked">12</p><p data-row="0" data-column="3" data-state="blocked">=</p><p data-row="0" data-column="2" data-state="correct">3</p><p data-row="0" data-column="1" data-state="blocked">*</p><p data-row="0" data-column="0" data-state="blocked">4</p>

            <script>
                crucigrama.paintMathword();
                document.addEventListener('keydown', crucigrama.manageEvent.bind(crucigrama));
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

        
    <section data-element="form"><h3>Formulario de partida ganada</h3><form action="#" method="post" name="record"><p><label for="name">Nombre: </label><input type="text" id="name" name="name" placeholder="Escriba su nombre" required=""></p><p><label for="surname">Apellido: </label><input type="text" id="surname" name="surname" placeholder="Escriba su apellido" required=""></p><p><label for="time">Tiempo en segundos: </label><input type="text" id="time" name="time" value="19" readonly=""></p><p><label for="level">Nivel de dificultad: </label><input type="text" id="level" name="level" value="Fácil" readonly=""></p><p><label for="current_time">Día y hora: </label><input name="current_time" id="current_time" value="19/12/2023 - 16 : 45 : 8"></p><input type="submit" value="Enviar"></form></section></main>


</body></html>