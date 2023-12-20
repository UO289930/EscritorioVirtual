<!DOCTYPE HTML>
<html lang="es"><head>
        <!-- Datos que describen el documento -->
        <meta charset="UTF-8">
        <meta name="author" content="Sergio Truébano Robles">
        <meta name="description" content="Inventario de productos informáticos">
        <meta name="keywords" content="juego,inventario,componentes,productos,csv">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Escritorio Virtual - Inventario de Componentes</title>

        <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
        <link rel="stylesheet" type="text/css" href="../estilo/estilo.css">
        <link rel="stylesheet" type="text/css" href="../estilo/layout.css">
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
            <h2>Inventario de componentes de ordenador</h2>
            <section>
                <h3>Funciones básicas</h3>
                <form action="#" method="post">
                    <label for="create">Inicializar la base de datos: </label>
                    <input type="submit" id="create" name="create" value="Crear" tabindex="13">
                </form>

                <form action="#" method="post">
                    <p>
                        <label for="input">Crear nueva base de datos con la información de CSV</label>
                        <input type="submit" id="input" name="input" value="Crear" tabindex="14">
                    </p>
                </form>

                <form action="#" method="post">
                    <label for="output">Crear un documento externo CSV con los datos de la base de datos:</label>
                    <input type="submit" id="output" name="output" value="Crear" tabindex="15">
                </form>
            </section>

            <section>
                <h3>Productos</h3>
                <p>Placas Base: ASUS ROG Strix Z590-E por 279.99€ (producto de ASUS). Cantidad en stock: 6</p><p>Cajas/Torres: Cooler Master MasterBox Q300L por 49.99€ (producto de Cooler Master). Cantidad en stock: 10</p><p>Memoria RAM: Corsair Vengeance LPX 16GB por 79.99€ (producto de Corsair). Cantidad en stock: 4</p><p>Fuentes de Alimentación: EVGA SuperNOVA 850 G5 por 129.99€ (producto de EVGA Corporation). Cantidad en stock: 17</p><p>Procesadores: Intel Core i9-11900K por 549.99€ (producto de Intel Corporation). Cantidad en stock: 12</p><p>Periféricos: Kingston HyperX Cloud II por 99.99€ (producto de Kingston Technology). Cantidad en stock: 4</p><p>Periféricos: Logitech G Pro X Mechanical Keyboard por 149.99€ (producto de Logitech). Cantidad en stock: 18</p><p>Tarjetas Gráficas: NVIDIA GeForce RTX 3080 por 799.99€ (producto de NVIDIA Corporation). Cantidad en stock: 29</p><p>Refrigeración: NZXT Kraken X63 por 149.99€ (producto de NZXT Corporation). Cantidad en stock: 2</p><p>Almacenamiento SSD: Samsung 970 EVO Plus 1TB por 149.99€ (producto de Samsung Electronics). Cantidad en stock: 22</p>            </section>
        </main>

    
</body></html>