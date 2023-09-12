<?php
include 'model.php';

$model = new Model();

$rows = $model->fetch_damage();

echo json_encode($rows);