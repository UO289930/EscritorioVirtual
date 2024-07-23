<?php 

    class Storage{
        private $server;
        private $user;
        private $pass;
        private $dbname;

        private $result = "";

        public function __construct() {
            $this->server = "localhost";
            $this->user = "DBUSER2023";
            $this->pass = "DBPSWD2023";
            $this->dbname = "storage";
        }

        public function get_result(){
            return $this->result;
        }

        // Saca la información pedida
        public function fetch_information(){

            if(isset($_POST["create"])){
                $this->create_database();
            }
            if(isset($_POST["input"])){
                $this->import_CSV();
            }
            if(isset($_POST["output"])){
                $this->export_CSV();
            }
            if(isset($_POST["deliveries"])){
                $this->result = $this->fetch_deliveries();
            }
            if(isset($_POST["add_product"])){
                $this->result = $this->add_product();
            }
            if(isset($_POST["add_delivery"])){
                $this->result = $this->add_delivery();
            }
        }

        private function create_database(){
            $db = new mysqli($this->server, $this->user, $this->pass);

            if ($db->connect_error) {
                $this->result = "<p>No fue posible crear la base de datos</p>";
                return;
            }

            $sql = "DROP DATABASE IF EXISTS " . $this->dbname;    
            $db->query($sql);
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->dbname;

            if ($db->query($sql)) {

                $db->select_db($this->dbname);

                $sql = file_get_contents('create_table_storage.sql');

                // Sentencias sql a array
                $creates = explode(';', $sql);

                foreach ($creates as $create) {
                    if(!empty($create)){
                        $result = $db->query($create);
                    }
                }

                $this->result = "<p>Base de datos creada con éxito</p>";
            } else{
                $this->result = "<p>Error al crear la base de datos</p>";
            }

            $db->close();
        }

        private function import_CSV(){

            $this->create_database();

            if(!$this->import_categories_from_CSV()){
                $this->result = "<p>Error al importar categorías</p>";
                return;
            }

            if(!$this->import_suppliers_from_CSV()){
                $this->result = "<p>Error al importar proveedores</p>";
                return;
            }

            if(!$this->import_products_from_CSV()){
                $this->result = "<p>Error al importar productos</p>";
                return;
            }

            if(!$this->import_companies_from_CSV()){
                $this->result = "<p>Error al importar compañías</p>";
                return;
            }

            if(!$this->import_workers_from_CSV()){
                $this->result = "<p>Error al importar repartidores</p>";
                return;
            }

            if(!$this->import_deliveries_from_CSV()){
                $this->result = "<p>Error al importar entregas</p>";
                return;
            }
        }

        private function import_categories_from_CSV(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if ($db->connect_error) {
                return false;
            }

            $file = fopen("categories.csv", "r");

            if ($file) {

                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

                    $insert = "INSERT INTO category (category_id,category_name) VALUES (?,?)";
                    $query = $db->prepare($insert);
                    $query->bind_param("ss", $data[0], $data[1]);
                    $query->execute();
                    $query->close();
                }

                fclose($file);
            }

            $db->close();
            return $file;
        }

        private function import_suppliers_from_CSV(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if ($db->connect_error) {
                return "<p>Error de conexión al intentar importar datos</p>";
            }

            $file = fopen("suppliers.csv", "r");

            if ($file) {

                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

                    $insert = "INSERT INTO supplier (supplier_id, supplier_name) VALUES (?,?)";
                    $query = $db->prepare($insert);
                    $query->bind_param("ss", $data[0], $data[1]);
                    $query->execute();
                    $query->close();
                }

                fclose($file);
            }

            $db->close();
            
            return $file;
        }

        private function import_products_from_CSV(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if ($db->connect_error) {
                return false;
            }

            $file = fopen("products.csv", "r");

            if ($file) {

                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

                    $insert = "INSERT INTO product (product_id, product_name, product_price, category_id, supplier_id) VALUES (?,?,?,?,?)";
                    $query = $db->prepare($insert);
                    $query->bind_param("sssss", $data[0], $data[1], $data[2], $data[3], $data[4]);
                    $query->execute();
                    $query->close();
                }

                fclose($file);
            }

            $db->close();
            
            return $file;
        }

        private function import_companies_from_CSV(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if ($db->connect_error) {
                return false;
            }

            $file = fopen("companies.csv", "r");

            if ($file) {

                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

                    $insert = "INSERT INTO delivery_company (company_id, company_name) VALUES (?,?)";
                    $query = $db->prepare($insert);
                    $query->bind_param("ss", $data[0], $data[1]);
                    $query->execute();
                    $query->close();
                }

                fclose($file);
            } 

            $db->close();
            
            return $file;
        }

        private function import_workers_from_CSV(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if ($db->connect_error) {
                return false;
            }

            $file = fopen("workers.csv", "r");

            if ($file) {

                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

                    $insert = "INSERT INTO delivery_worker (worker_id, worker_dni, worker_name, worker_surname, company_id) VALUES (?,?,?,?,?)";
                    $query = $db->prepare($insert);
                    $query->bind_param("sssss", $data[0], $data[1], $data[2], $data[3], $data[4]);
                    $query->execute();
                    $query->close();
                }

                fclose($file);
            }

            $db->close();
            
            return $file;
        }

        private function import_deliveries_from_CSV(){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if ($db->connect_error) {
                return false;
            }

            $file = fopen("deliveries.csv", "r");

            if ($file) {

                while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {

                    $insert = "INSERT INTO is_delivered (delivery_date, product_id, product_quantity, worker_id) VALUES (?,?,?,?)";
                    $query = $db->prepare($insert);
                    $query->bind_param("ssss", $data[0], $data[1], $data[2], $data[3]);
                    $query->execute();
                    $query->close();
                }

                fclose($file);
            }

            $db->close();
            
            return $file;
        }

        private function export_CSV(){
            if(!$this->export_categories_to_CSV()){
                $this->result = "<p>Error al exportar categorías</p>";
                return;
            }
            if(!$this->export_suppliers_to_CSV()){
                $this->result = "<p>Error al exportar proveedores</p>";
                return;
            }
            if(!$this->export_products_to_CSV()){
                $this->result = "<p>Error al exportar productos</p>";
                return;
            }
            if(!$this->export_companies_to_CSV()){
                $this->result = "<p>Error al exportar compañías</p>";
                return;
            }
            if(!$this->export_workers_to_CSV()){
                $this->result = "<p>Error al exportar repartidores</p>";
                return;
            }
            if(!$this->export_deliveries_to_CSV()){
                $this->result = "<p>Error al exportar entregas</p>";
                return;
            }
        }

        private function common_export_to_CSV($file_name, $sql){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

            if ($db->connect_error) {
                return false;
            }
            $file = fopen($file_name, "w");

            if ($file) {
                
                $result = $db->query($sql);

                while ($row = $result->fetch_assoc()) {
                    fputcsv($file, $row);
                }
                
                fclose($file);
            }

            $db->close();
            return $file;
        }

        private function export_categories_to_CSV(){
            return $this->common_export_to_CSV("categories.csv", "SELECT category_id, category_name FROM category");
        }

        private function export_suppliers_to_CSV(){
            return $this->common_export_to_CSV("suppliers.csv", "SELECT supplier_id, supplier_name FROM supplier");
        }

        private function export_products_to_CSV(){
            return $this->common_export_to_CSV("products.csv", "SELECT product_id, product_name, product_price, category_id, supplier_id FROM product");
        }

        private function export_companies_to_CSV(){
            return $this->common_export_to_CSV("companies.csv", "SELECT company_id, company_name FROM delivery_company");
        }

        private function export_workers_to_CSV(){
            return $this->common_export_to_CSV("workers.csv", "SELECT worker_id, worker_dni, worker_name, worker_name, company_id FROM delivery_worker");
        }

        private function export_deliveries_to_CSV(){
            return $this->common_export_to_CSV("deliveries.csv", "SELECT delivery_date, product_id, product_quantity, worker_id FROM is_delivered");
        }

        private function normal_select($select){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
            if($db->connect_error){
                return;
            }
            $result = $db->query($select);
            $db->close();

            return $result;
        }

        private function safe_select_1_param($select, $arg){
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
            if($db->connect_error){
                return;
            }

            $query = $db->prepare($select);
            $query->bind_param("s", $arg);
            $query->execute();
            
            $result = $query->get_result();

            $query->close();
            $db->close();

            return $result;
        }

        // Saca todos los productos, con sus categorías, proveedores y la cantidad disponible
        public function fetch_stock(){

            $select = "SELECT p.product_name as nombre, p.product_price as precio, c.category_name as categoria, s.supplier_name as proveedor, SUM(d.product_quantity) as total
                        FROM product p, category c, supplier s, is_delivered d
                        WHERE p.category_id = c.category_id AND p.supplier_id = s.supplier_id AND p.product_id = d.product_id
                        GROUP BY p.product_name
                        ORDER BY p.product_name";
            
            $result = $this->normal_select($select);
            $output = "";

            if($result->fetch_assoc()!=NULL){
                $result->data_seek(0);

                while($row = $result->fetch_assoc()){
                    $output = $output . "<p>" . $row["categoria"] . ": " . $row["nombre"] . " por " . $row["precio"] . "€ (producto de " . $row["proveedor"] . "). Cantidad en stock: " . $row["total"] . "</p>";
                }
            }

            return $output;
        }

        // Saca los movimientos de un producto
        private function fetch_deliveries(){
            $select = "SELECT w.worker_name as repartidor, c.company_name as empresa, d.delivery_date as dia, p.product_name as nombre, d.product_quantity
                        FROM product p, is_delivered d, delivery_worker w, delivery_company c
                        WHERE p.product_id = d.product_id and d.worker_id = w.worker_id and w.company_id = c.company_id
                        ORDER BY w.worker_name";

            return $this->normal_select($select);
        }

        // Añade un producto nuevo
        private function add_product(){
            $product_name = $_POST["product_name"];
            $product_price = $_POST["product_price"];
            $category_name = $_POST["category_name"];
            $supplier_name = $_POST["supplier_name"];

            $select = "SELECT category_id FROM category WHERE category_name = ?";
            $category_id = $this->safe_select($select, $category_name);
            
            if(!$category_id->num_rows>0){
                return "<p>La categoría seleccionada no existe</p>";
            }
            $category_id = $category_id->fetch_assoc()["category_id"];

            $select = "SELECT supplier_id FROM supplier WHERE supplier_name = ?";
            $supplier_id = $this->safe_select($select, $category_name);
            if(!$supplier_id->num_rows>0){
                // TODO
                return "<p>El proveedor seleccionada no existe</p>";
            }
            $supplier_id = $supplier_id->fetch_assoc()["supplier_id"];

            $insert = "INSERT INTO product (product_name,product_price,category_id,supplier_id) VALUES (?,?,?,?)";

            // INSERT
            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
            $query = $db->prepare($insert);
            $query->bind_param("ssss", $product_name, $product_price, $category_id, $supplier_id);
            $query->execute();

            $query->close();
            $db->close();
        }

        // Añade un nuevo movimiento (entrada o salida de n productos) siempre y cuando sea posible
        private function add_delivery(){
            $product_name = $_POST["product_name"];
            $product_quantity = $_POST["product_quantity"];
            $delivery_date = date("Y-m-d H:i:s");
            $worker_dni = $_POST["worker_dni"];
            $type = $_POST["type"];

            $select = "SELECT product_id FROM product WHERE product_name = ?";
            $product_id = $this->safe_select($select, $product_name);
            
            if(!$product_id->num_rows>0){
                // TODO
                return "<p>El producto introducido no existe</p>";
            }
            $product_id = $product_id->fetch_assoc()["product_id"];

            $select = "SELECT worker_id FROM delivery_worker WHERE worker_dni = ?";
            $worker_id = $this->safe_select($select, $worker_dni);
            if(!$worker_id->num_rows>0){
                // TODO
                return "<p>El repartidor introducido no existe</p>";
            }
            $worker_id = $worker_id->fetch_assoc()["worker_id"];
            

            $insert = "INSERT INTO is_delivered (delivery_date, product_id, product_quantity, worker_id) VALUES (?,?,?,?)";
            $quantity = intval($product_quantity);

            if ($type==="Salida"){
                $select = "SELECT SUM(product_quantity) as total
                            FROM is_delivered
                            WHERE product_id = ?
                            GROUP BY product_id";
                $result = $this->safe_select_1_param($select, $product_id);

                $left = $result->fetch_assoc()["total"];

                // TODO
                if($left-$quantity < 0 ){
                    return "<p>No hay tantos productos como desea</p>";
                }

                $quantity = -$quantity;
            }

            $db = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
            $query = $db->prepare($insert);
            $query->bind_param("ssss", $delivery_date, $product_id, $quantity, $worker_id);
            $query->execute();

            $query->close();
            $db->close();

        }
    }

    $storage = new Storage();
    $storage->fetch_information();

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <!-- Datos que describen el documento -->
        <meta charset="UTF-8" />
        <meta name ="author" content ="Sergio Truébano Robles" />
        <meta name ="description" content ="Inventario de productos informáticos" />
        <meta name ="keywords" content ="juego,inventario,componentes,productos,csv" />
        <meta name ="viewport" content ="width=device-width, initial-scale=1.0" />
        <title>Escritorio Virtual - Inventario de Componentes</title>

        <!-- añadir el elemento link de enlace a la hoja de estilo dentro del <head> del documento html -->
        <link rel="stylesheet" type="text/css" href="../estilo/estilo.css" />
        <link rel="stylesheet" type="text/css" href="../estilo/layout.css" />
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
            <h2>Inventario de componentes de ordenador</h2>
            <section>
                <h3>Funciones básicas</h3>
                <form action="#" method="post">
                    <label for="create">Inicializar la base de datos: </label>
                    <input type="submit" id="create" name="create" value="Crear" tabindex="13" title="Crear base de datos">
                </form>

                <form action="#" method="post">
                    <p>
                        <label for="input">Crear nueva base de datos con la información de CSV</label>
                        <input type="submit" id="input" name="input" value="Crear" tabindex="14" title="Crear base de datos a través de CSV">
                    </p>
                </form>

                <form action="#" method="post">
                    <label for="output">Crear un documento externo CSV con los datos de la base de datos:</label>
                    <input type="submit" id="output" name="output" value="Crear" tabindex="15" title="Extraer base de datos a CSV">
                </form>
            </section>

            <section>
                <h3>Productos</h3>
                <?php echo $storage->fetch_stock(); ?>
            </section>
        </main>

    </body>
</html>