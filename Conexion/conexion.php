<?php
class conectar {
    private $logFile;
    
    public function __construct() {
        // Configuración del archivo de log
        $this->logFile = __DIR__ . '/../logs/errores_control_db.log';
        $this->ensureLogFileExists();
    }
    
    private function ensureLogFileExists() {
        if (!file_exists(dirname($this->logFile))) {
            mkdir(dirname($this->logFile), 0755, true);
        }
        
        if (!file_exists($this->logFile)) {
            file_put_contents($this->logFile, "[" . date('Y-m-d H:i:s') . "] Inicio del log\n");
        }
    }
    
    private function logError($message) {
        $logMessage = "[" . date('Y-m-d H:i:s') . "] " . $message . "\n";
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
    
    public function conexion() {
        $servidor = 'localhost';
        $usuario = 'root';
        $password = '1234';
        $basedatos = 'con_plan';
        
        $conexion = @mysqli_connect($servidor, $usuario, $password, $basedatos);
        
        if (!$conexion) {
            // Registrar error en logs
            error_log("Error de conexión MySQL: " . mysqli_connect_error(), 3, "errores_db.log");
            
            // Mostrar mensaje seguro al usuario (sin detalles sensibles)
            die("Lo sentimos, estamos experimentando problemas técnicos. Por favor intente más tarde.");
            
            // Opcionalmente podrías redirigir a una página de error:
            // header('Location: error.php');
            // exit;
        }
        
        if (!$conexion->set_charset("utf8")) {
            error_log("Error al establecer charset: " . $conexion->error, 3, "errores_db.log");
        }
        
        return $conexion;
    }
}
?>