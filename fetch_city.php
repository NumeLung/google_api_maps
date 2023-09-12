<?php
include 'model.php';

$model = new Model();

$rows = $model->fetch_city();

echo json_encode($rows);