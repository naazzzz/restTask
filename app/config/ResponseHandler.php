<?php
// Send API response.
function sendResponse($data)
{
    echo $data;
    exit;
}

function sendSuccess($data)
{
//    echo json_encode($data);
    sendResponse(
//        json_encode($data),
    $data

    );
}

function sendError($data)
{
    sendResponse(
        json_encode($data),
        array('Content-Type: application/json', 'HTTP/1.1 500 Internal Server Error')
    );
}