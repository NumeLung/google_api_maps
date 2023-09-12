<?php

class model
{
    private $server = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "google_heatmap";
    private $conn;
    public function __construct()
    {
        try {
            $this->conn=new mysqli($this->server, $this->username, $this->password, $this->db);
        } catch (\Throwable $th){
            //throw $th;
            echo "Connetion error" . $th->getMessage();
        }
    }

    public function fetch_city(){
        $data = [];

        $query = "SELECT DISTINCT(city_name) AS city, id_city FROM cities ORDER BY id_city";

        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function fetch_year(){
        $data = [];

        $query = "SELECT DISTINCT(YEAR(crash_date)) AS year FROM crashes";
        if ($sql = $this->conn->query($query)){
            while ($row = mysqli_fetch_assoc($sql)){
                $data[] = $row;
            }
            return $data;
        }
    }

    public function fetch_damage(){
        $data = [];

        $query = "SELECT descr AS damage, id FROM damage_descr ORDER BY id";
        if ($sql = $this->conn->query($query)){
            while ($row = mysqli_fetch_assoc($sql)){
                $data[] = $row;
            }
            return $data;
        }
    }

    public function fetch_coordinates()
    {
        $data = [];

        $query = "SELECT crash_lat, crash_lng FROM crashes WHERE %s  ORDER BY id_crash";
        $where = [];
        $where[] = 1;
        if(!empty($_POST['year'])){
            $year = intval($_POST['year']);
            $where[] = "crash_date BETWEEN '$year-01-01' AND '$year-12-31' ";
        }
        if(!empty($_POST['city'])){
            $where[] = "id_city = " . intval($_POST['city']);
        }
        if(!empty($_POST['damage'])){
            $where[] = "id_crash_dmg = " . intval($_POST['damage']);
        }

        $query = sprintf($query, implode("\n AND ", $where));


        if ($sql = $this->conn->query($query)) {
            while ($row = mysqli_fetch_assoc($sql)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function fetch1(){
        $data = [];

        $query = "
                SELECT
                    c.id_crash,
                    c.crash_date,
                    ci.city_name AS city,
                    d.descr AS crash_damage,
                    c.crash_lat,
                    c.crash_lng,
                    c.crash_descr
                FROM
                    crashes c
                JOIN
                    cities ci ON c.id_city = ci.id_city
                JOIN
                    damage_descr d ON c.id_crash_dmg = d.id;
 ";
        if ($sql = $this->conn->query($query)){
            while ($row = mysqli_fetch_assoc($sql)){
                $data[] = $row;
            }
        }
        return $data;
    }

    /*public function fetch_coords(){

    }*/
}
