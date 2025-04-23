<?php
	class conectar{
		public static function conexion()
		{
			include 'conexion.php';
			$conexion->query("SET NAMES 'utf-8'");
			return $conexion;
		}
	}
?>