<?php 

	function productosCsvToArray($archivo = '', $separador = ','){
	    if (!file_exists($archivo) || !is_readable($archivo))
	        return false;

	    $header = null;
	    $data = array();
	    if (($handle = fopen($archivo, 'r')) !== false)
	    {
	        while (($row = fgetcsv($handle, 1000, $separador)) !== false)
	        {
	            if (!$header)
	                $header = $row;
	            else
	                $data[] = array_combine($header, $row);
	        }
	        fclose($handle);
	    }

	    return $data;
	}

 ?>