<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use DB;

trait PostgisTrait
{
    public function createPointAtLinestring($geom1, $geom2, $m1, $m2)
    {

        $line = DB::select("SELECT ST_Length(ST_MakeLine('".$geom1."'::geometry,'".$geom2."'::geometry)::geography) as length")[0];
        if (intval($line->length) === 0)
            return $this->createPointFromGeometry($geom1);
        else
            return DB::select("SELECT ST_X(ST_LineInterpolatePoint(ST_MakeLine('".$geom1."'::geometry,'".$geom2."'::geometry), (". $m1 ." - ". $m2 .")/ST_Length(ST_MakeLine('".$geom1."'::geometry,'".$geom2."'::geometry)::geography) )) as longitude,
                                  ST_Y(ST_LineInterpolatePoint(ST_MakeLine('".$geom1."'::geometry,'".$geom2."'::geometry), (". $m1 ." - ". $m2 .")/ST_Length(ST_MakeLine('".$geom1."'::geometry,'".$geom2."'::geometry)::geography) )) as latitude
                            ")[0];
    }

    public function createPointFromGeometry($geom1)
    {
        return DB::select("SELECT ST_X('".$geom1."') as longitude,
                                  ST_Y('".$geom1."') as latitude
            ")[0];
    }

    public function createPointFromLatLon($lat, $lon)
    {
        return DB::select("SELECT ST_MakePoint($lat, $lon)")
    }
}
