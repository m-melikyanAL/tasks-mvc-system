<?php 

class Controller 
{
    protected $view;

    protected function view($template,$params=[])
    {
        $this->view = new View($template,$params);
        return $this->view;
    }

    /**
     * Use for prepare return type and get post data
     * @return  array
     */
    protected function preparePostData()
    {
        header('Content-Type: application/json; charset=utf-8');
        return json_decode(file_get_contents('php://input'), true);
    }


    /**
     * Use for checking response
     * @param array $data
     * @return  array
     */
    protected function prepareResponse($data)
    {
        $response = ["data" => $data];
        $json = json_encode($response);
        // Check if json_encode() failed
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode([
                "status" => "error",
                "message" => json_last_error_msg()
            ]);
        } else {
            echo $json;
        }
    }
}