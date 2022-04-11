<?php
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode(array('status' => 'error', 'data' => 'NOT_FOUND'), JSON_UNESCAPED_UNICODE); 