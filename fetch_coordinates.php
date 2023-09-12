<?php
include 'model.php';

$model = new Model();

$rows = $model->fetch_coordinates();

echo json_encode($rows);