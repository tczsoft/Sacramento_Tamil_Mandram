<?php
require './API/Models/sponsor.php';
use Auth\Authentication;
use Models\ModelsSponsor;
use MVC\Controller;
class ControllersSponsor extends Controller {
    public function getSponsorbyid(){
        try {
               $id=$this->request->get('id');
               $blog=new ModelsSponsor();
               $resdata =$blog->lastrecord($id);
               $this->response->sendStatus(200);
               $this->response->setContent($resdata);
            } catch (Exception $e) {
            echo 'Error Message: ' . $e->getMessage();
        } 
    }
    public function getallsponsor(){
        try {
                $id=$this->request->get();
                $blog=new ModelsSponsor();
                $resdata =$blog->getall();
                if($resdata) {
                $this->response->sendStatus(200);
                $this->response->setContent($resdata);
            } else {
                $this->response->sendStatus(404);
                $this->response->setContent(['message' => 'No sponsors found']);
            }
            } catch (Exception $e) {
            echo 'Error Message: ' . $e->getMessage();
        } 
    }

    // public function savesponsor()
    // {
    //     try {
    //        $verify = Authentication::verifyJWT();
    //        if ($verify == "Unauthorized") {
    //            http_response_code(401);
    //            echo json_encode(array("error" => "Unauthorized"));
    //        } else {
      
    //             $postdata = file_get_contents("php://input");
    //             $reqdata = json_decode($postdata, true);
                                

    //              $blog=new ModelsSponsor();
    //              $resdata =$blog->save($reqdata);
    //              $this->response->sendStatus(200);
    //              $this->response->setContent($resdata);
    //        }
            
    //     } catch (Exception $e) {
    //         echo 'Error Message: ' . $e->getMessage();
    //     }
    // }

    public function savesponsor() {
        try {
            if (Authentication::verifyJWT() === "Unauthorized") {
                http_response_code(401);
                echo json_encode(["error" => "Unauthorized"]);
                return;
            }
    
            $reqdata = $_SERVER['CONTENT_TYPE'] === 'application/json' ? json_decode(file_get_contents("php://input"), true) : $_POST;
            if (!$reqdata) {
                echo json_encode(["error" => "Invalid or missing input data"]);
                return;
            }

            if (!empty($_FILES['Image']['tmp_name'])) {
                $folderName = 'Upload/sponsor';
                if (!file_exists($folderName)) mkdir($folderName, 0777, true);
                $destination = "$folderName/" . time() . '_' . $_FILES['Image']['name'];
                move_uploaded_file($_FILES['Image']['tmp_name'], $destination);
                $reqdata['Image'] = $destination;
            } elseif (isset($reqdata['Image'])) {
                $reqdata['Image'] = $reqdata['Image'];
            } else {
                $reqdata['Image'] = '';
            }
    
            $faculties = new ModelsSponsor();
            $resdata = $faculties->save($reqdata);
    
            $this->response->sendStatus(200);
            $this->response->setContent($resdata);
    
        } catch (Exception $e) {
            echo 'Error Message: ' . $e->getMessage();
        }
    }
    
    
    public function updatesponsor() {
        try {
            $verify = Authentication::verifyJWT();
            if ($verify == "Unauthorized") {
                http_response_code(401);
                echo json_encode(["error" => "Unauthorized"]);
                return;
            }
            $reqdata = $_POST;
            $files = $_FILES;
    
            if (empty($reqdata)) {
                throw new Exception("No data provided for update.");
            }
    
            if (!empty($_FILES['Image']['tmp_name'])) {
                $folderName = 'Upload/sponsor';
                if (!file_exists($folderName)) mkdir($folderName, 0777, true);
                $destination = "$folderName/" . time() . '_' . $_FILES['Image']['name'];
                move_uploaded_file($_FILES['Image']['tmp_name'], $destination);
                $reqdata['Image'] = $destination;
            } elseif (isset($reqdata['Image'])) {
                $reqdata['Image'] = $reqdata['Image'];
            } else {
                $reqdata['Image'] = '';
            }
    
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception("Missing ID parameter.");
            }
            $resdata = (new ModelsSponsor)->update($reqdata, $id);
            $this->response->sendStatus(200);
            $this->response->setContent($resdata);
        } catch (Exception $e) {
            http_response_code(400); 
            echo json_encode(["error" => $e->getMessage()]);
        }
    }


    public function deletesponsor(){
        try {
           $verify = Authentication::verifyJWT();
           if ($verify == "Unauthorized") {
               http_response_code(401);
               echo json_encode(array("error" => "Unauthorized"));
           }  if (isset($_GET['id'])) {
            error_log("Deleting sponsor with ID: " . $_GET['id']);
            $blog = new ModelsSponsor();
            $blog->Delete($_GET['id']);
            $this->response->sendStatus(200);
            $this->response->setContent("Deleted successfully");
        } else {
            error_log("ID parameter missing in request");
            $this->response->sendStatus(400);
            echo json_encode(["error" => "ID parameter missing"]);
        }
            
        } catch (Exception $e) {
            echo 'Error Message: ' . $e->getMessage();
        }

    }
}