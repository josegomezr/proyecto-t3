<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dump extends MY_Controller {
    public function post_nuevo($id_dispositivo)
    {
        $this->load->model('unidad_model');
        $this->load->model('dispositivo_model');
        $this->load->model('salida_model');
        $this->load->model('entrada_model');
        $this->load->helper('array');	
        
        $dispositivo = $this->dispositivo_model->buscar(
        	array('id_dispositivo' => $id_dispositivo
        ));
        
        var_dump($this->db->last_query());

        if ($dispositivo->num_rows()== 0) {
            exit("err-dispo");
        }
        $dispositivo = $dispositivo->row();

        // $input = "10.448633333|-64.148205|0.427|2016-06-30T02:24:55.000Z|5";
        $input = file_get_contents($_FILES['dump']['tmp_name']);
        $input = trim($input, "\n");
        $lines = explode("\n", $input);

        $points = array();

        foreach ($lines as $line) {
            $parsed = $this->parseLine($line);
            if ($parsed) {
                $points[] = $parsed;
            }
        }

        if (count($points) == 0) {
            exit("error-no-point");
        }

        $inicio_recorrido = $points[0];

        $criteria = array(
            'id_unidad' => $dispositivo->id_unidad
        );

        $salida = $this->salida_model->buscar_en_proceso($criteria);
        
        if ($salida->num_rows() == 0) {
            $datos_provisionales = array(
                'id_unidad' => $dispositivo->id_unidad,
                'id_recorrido' => $dispositivo->id_recorrido,
                'id_conductor' => null,
                'id_acompaniante' => null,
                'hora_salida' => $inicio_recorrido['hora_punto'],
                'fecha_salida' => $inicio_recorrido['fecha_punto']
            );
            $salida = $this->crear_salida_provisional($datos_provisionales);
        } else {
            echo "usando existente";
            $salida = $salida->row_array();
        }
        echo "salida: " . $salida['id_salida'];

        file_put_contents("/home/rsennin/www/log_http.txt", json_encode(array('input' => $input)));

        $entrada = $this->entrada_model->buscar('id_salida', $salida['id_salida']);
        if ($entrada->num_rows() == 0) {
            // mark out as in
            $registro = array();

            $registro['id_salida'] = $salida['id_salida'];
            
            if ($dispositivo->id_recorrido != $salida['id_recorrido']) {
                // $registro['observacion_entrada'] = "ESTA SALIDA NO CUMPLE CON EL RECORRIDO ASIGNADO PARA LA UNIDAD";
            }

            $endRecorrido = array_pop($points);
            $points[] = $endRecorrido;

            $registro['fecha_entrada'] = $endRecorrido['fecha_punto'];
            $registro['hora_entrada'] = $endRecorrido['hora_punto'];

            $this->entrada_model->crear($registro);
        }
        
        $this->salida_model->guardar_trazado($salida['id_salida'], $points);


    }

    public function parseLine($line) {
		list($lat, $lon, $speed, $datetime, $satellites) = explode('|', $line);
        $local_date = DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $datetime, new DateTimeZone('UTC'));
        $local_date->setTimeZone(new DateTimeZone('America/Caracas'));

        if ( !((float)$lat && (float)$lon) ) {
        	return false;
        }

        return (
            array(
                'fecha_punto' => $local_date->format('Y-m-d'),
                'hora_punto' => $local_date->format('H:i:s'),
                'latitud' => ($lat),
                'longitud' => ($lon),
                'velocidad' => $speed,
                'num_satelites' => $satellites
            )
        );
    }

    public function post_dispositivo($id_dispositivo, $EOT = false) {
    
        $this->load->model('unidad_model');
        $this->load->model('dispositivo_model');
        $this->load->model('salida_model');
        $this->load->model('entrada_model');
        $this->load->helper('array');
        
        // look up all data
        $dispositivo = $this->dispositivo_model->buscar('id_dispositivo', $id_dispositivo);
        
        if ($dispositivo->num_rows()== 0) {
            exit("err-dispo");
        } else {
            $dispositivo = $dispositivo->row();
        }

        $input = file_get_contents('php://input');
        $input = trim($input, "\n");
        $lines = explode("\n", $input);
        $points = array();
        
        foreach ($lines as $line) {
            $parsed = $this->parseNMEA($line);
            if ($parsed) {
                $points[] = $parsed;
            }
        }
        if (count($points) == 0) {
            exit("error-no-point");
        }

        $inicio_recorrido = reset($points);
        $this->db->protect_identifiers('salida');
        $criteria = array(
            'cedula_chofer' => true,
            'placa_unidad' => $dispositivo->placa_unidad
        );

        $salida = $this->salida_model->buscar_incompletas($criteria);
        
        if ($salida->num_rows() == 0) {
            $datos_provisionales = array(
                'placa_unidad' => $dispositivo->placa_unidad,
                'id_recorrido' => $dispositivo->id_recorrido,
                'cedula_chofer' => null,
                'cedula_acompaniante' => null,
                'observacion_salida' => 'SALIDA NO NOTIFICADA',
                'hora_salida' => $inicio_recorrido['hora_punto'],
                'fecha_salida' => $inicio_recorrido['fecha_punto']
            );
            $salida = $this->crear_salida_provisional($datos_provisionales);
        } else {
            echo "usando existente";
            $salida = $salida->row_array();
        }

        file_put_contents("/home/rsennin/www/log_http.txt", json_encode(array('input' => $input, 'EOT' => $EOT)));

        if ($EOT) {
            echo "fin de transmisión, cerrando salida";
            $entrada = $this->entrada_model->buscar('id_salida', $salida['id_salida']);
            if ($entrada->num_rows() == 0) {
                // mark out as in
                $registro = array();

                $registro['id_salida'] = $salida['id_salida'];
                if ($dispositivo->id_recorrido != $salida['id_recorrido']) {
                    $registro['observacion_entrada'] = "ESTA SALIDA NO CUMPLE CON EL RECORRIDO ASIGNADO PARA LA UNIDAD";
                }
                $registro['fecha_entrada'] = date('Y-m-d');
                $registro['hora_entrada'] = date('H:i');

                $this->entrada_model->crear($registro);
            }
        }
        $this->salida_model->guardar_trazado($salida['id_salida'], $points);

        
    }

    public function crear_salida_provisional($datos_provisionales) {
    
        echo "salida sin notificar, creando salida";

        $this->salida_model->crear($datos_provisionales);
        $salida = $datos_provisionales;
        $salida['id_salida'] = $this->db->insert_id();
        return $salida;
    }

    public function parseNMEA($str) {
    

        // 2015-02-03,02:49:49,+1026.9183,-6408.8881,000.21,177.04,XXX
        // YYYY-MM-DD,HH:II:SS,+LATI.LATI,+LONG.LONG,SPEED.SP,ANGLE.AN,ERROR
        //   1           2        3            4      5         6     7
        $strArray = explode(',', $str);

        if (count($strArray) < 7) {
            return null;
        };

        $date = array_shift($strArray); // date
        $time = array_shift($strArray); // time
        // $latitude = ((float) array_shift($strArray))/1000000; // latitude
        // $longitude = ((float) array_shift($strArray))/1000000; // longitude

        $latitude = ( array_shift($strArray)) / 10000000; // latitude
        $longitude = ( array_shift($strArray)) / 10000000; // longitude

        $speed = (float)array_shift($strArray) * 1.8625; // speed
        $angle = array_shift($strArray); // angle
        $num_sat = array_shift($strArray); // angle

        $local_date = DateTime::createFromFormat('Y-m-d H:i:s', "{$date} {$time}", new DateTimeZone('UTC'));
        $local_date->setTimeZone(new DateTimeZone('America/Caracas'));


        /// format date
        // $date = implode('-', array_reverse(array(substr($date, 0, 2), substr($date, 2, 2), "20" . substr($date, 4, 2))));
        // $time = implode(':', array(substr($time, 0, 2), substr($time, 2, 2), substr($time, 4, 2)));

        return (
            array(
                'fecha_punto' => $local_date->format('Y-m-d'),
                'hora_punto' => $local_date->format('H:i:s'),
                'latitud' => ($latitude),
                'longitud' => ($longitude),
                'velocidad' => $speed,
                'num_satelites' => $num_sat
            )
        );
    }

    public function DMSToDecimal($input) {
    
        $sign = $input[0] == '+' ? 1 : -1;
        $input = substr($input, 1);
        $pointPos = strpos($input, '.');
        $degree = (int)substr($input, 0, $pointPos-2);
        $minutes = (float)substr($input, $pointPos-2, 8);
        
        return $sign * round($degree + ($minutes/60), 6);
    }
}
