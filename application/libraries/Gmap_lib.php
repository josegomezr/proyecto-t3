<?php

class Gmap_lib
{
    private $radioAccion;

    function __construct() {
        $this->radioAccion = 0.000225;
    }

    public function get_radius() {
    
        return $this->radioAccion;
    }
    
    private function is_adjacent($pointA, $pointB) {
    
        return (pow($pointA->latitud-$pointB->latitud, 2) + pow($pointA->longitud-$pointB->longitud, 2)) < pow($this->radioAccion, 2);
    }

    private function get_adjacent_points($source, $path) {
        $adjacents = array();
        foreach ($path as $k => $point) {
            if ($this->is_adjacent($source, $point)) {
                $adjacents[] = $point;
            }
        }
        return $adjacents;
    }

    public function build_markers($puntos) {
    
        if (count($puntos) == 0) {
            return array();
        }

        $prevPunto = reset($puntos);
        
        if (!$prevPunto) {
            return array();
        }

        $prevTime = DateTime::createFromFormat('H:i:s', $prevPunto->hora_punto);
        $markers = array($prevPunto);

        foreach ($puntos as $k => $punto) {
            $punto->latitud = (float)$punto->latitud;
            $punto->longitud = (float)$punto->longitud;
            $punto->velocidad = (float)$punto->velocidad;

            $time = DateTime::createFromFormat('H:i:s', $punto->hora_punto);
            $diff = $prevTime->diff($time);

            if ((int)$diff->format("%s") > 45 && !$this->is_adjacent($punto, $prevPunto)) {
                $markers[] = $punto;
                $prevTime = $time;
                $prevPunto = $punto;
            }
        }
        
        return $markers;
    }

    public function cluster($puntos) {
    
        if (count($puntos) == 0) {
            return array();
        }

        $prevPunto = reset($puntos);
        
        if (!$prevPunto) {
            return array();
        }

        $markers = array($prevPunto);

        foreach ($puntos as $k => $punto) {
            $punto->latitud = (float)$punto->latitud;
            $punto->longitud = (float)$punto->longitud;

            if (!$this->is_adjacent($punto, $prevPunto)) {
                $markers[] = $punto;
                $prevPunto = $punto;
            }
        }
        
        return $markers;
    }

    public function get_bounds($puntos) {
    
        $minLat = 360;
        $minLong = INF;
        $maxLat = -180;
        $maxLong = -180;

        foreach ($puntos as $k => $punto) {
            $minLat = min($minLat, $punto->latitud);
            $minLong = min($minLong, $punto->longitud);

            $maxLat = max($punto->latitud, $maxLat);
            $maxLong = max($punto->longitud, $maxLong);
        }

        return array(
            'max' => array(
                'latitud' => $minLat,
                'longitud' => $minLong
            ),
            'min' => array(
                'latitud' => $maxLat,
                'longitud' => $maxLong
            )
        );
    }

    public function get_center($puntos) {
    
        $bounds = $this->get_bounds($puntos);
        return array(
            'latitud' => ($bounds['min']['latitud']+$bounds['max']['latitud'])/2,
            'longitud' => ($bounds['min']['longitud']+$bounds['max']['longitud'])/2
        );
    }

    public function get_detours($ruta, $puntos) {
    
        $detours = array();
        foreach ($ruta as $k => $point) {
            $detours = $this->get_adjacent_points($point, $puntos);
        }
        
        return $detours;
    }

    public function route_to_pairs($points) {
    
        $pairs = array();
        foreach ($points as $k => $point) {
            $pairs[] = array($point->latitud, $point->longitud);
        }
        return $pairs;
    }

    public function interpolate_points($a, $b, $frac) {
    
        $nx = $a[0]+($b[0]-$a[0])*$frac;
        $ny = $a[1]+($b[1]-$a[1])*$frac;
        return array($nx, $ny);
    }

    public function expand_line($start, $end) {
        $distanceA = sqrt(pow($start[0], 2) + pow($start[1], 2));
        $distanceB = sqrt(pow($end[0], 2) + pow($end[1], 2));
        $diff = abs($distanceB-$distanceA);
        $n_radius = ceil($diff/$this->radioAccion)+1;
        $dots = array($start);
        for ($i = 0; $i < $n_radius; $i++) {
            $dots[] = $this->interpolate_points($start, $end, $i/$n_radius);
        }
        $dots[] = $end;
        return $dots;
    }

    public function expand_path($puntos) {
        $prevPunto = array_shift($puntos);
        $full_path = array();

        foreach ($puntos as $k => $punto) {
            $full_path = array_merge($full_path, $this->expand_line($prevPunto, $punto));
            $prevPunto = $punto;
        }
        
        return $full_path;
    }
}
