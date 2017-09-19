<?php
class Controller_Photo extends Controller{
    private $model;
    function __construct()
    {
        parent::__construct();
        $id = $_SESSION['id'];
        $model = Model_Photo::getPhotosModel($id);
        if(isset($model) && !empty($model)) {
            $this->model = $model;
        }
    }

    function index()
    {
        $login = $_SESSION['login'];

        $tmp_name = $_FILES['avatar']['tmp_name'];
        $name = basename($_FILES['avatar']['name']);
        $type = $_FILES['avatar']['type'];
        $type = explode('/', $type);
        if($type[0] == 'image') {
            $this->model->uplodPhotos($tmp_name, $name, $login);
        }else{
            echo 'Загрузите изображение';
        }
        $img = $this->model->getUploadFile();
        $mass = [
            'id' => $img[0],
            'path' => $img[1],
            'width' => $img[2]
        ];
        echo json_encode($mass);
            //$this->view->generate(null, null ,$img);
    }

    function show(){
        $all = $_POST['all'];
        if(!isset($all) || empty($all)){
            $res = $this->model->showPhoto(5);
        }else{
            $res = $this->model->showPhoto();
        }
        $mass = [
            'photos' => $res
        ];
        echo json_encode($mass);

    }

    function upload(){
        //$img = $_POST['img']
        $count = $_POST['count'];
        $tmp_name = [];
        $name = [];
        for($i = 0; $i < $count; $i++){
            $type = explode('/', $_FILES["img-$i"]['type']);
            if($type[0] == "image") {
                $tmp_name[] = $_FILES["img-$i"]['tmp_name'];
                $name[] = basename($_FILES["img-$i"]['name']);
            }
        }
        $login = $_SESSION['login'];
        $res = $this->model->uplodPhotos($tmp_name, $name, $login);
        $mass = ['result' => $res];
        echo json_encode($mass);

    }

    function photo_show($id){
        $this->model = Model_Photo::getPhotosModel($id);
        $res = $this->model->getPhotos();
        echo json_encode(['photo' => $res]);

    }

    function get_one_photo(){
        $id_user = $_POST['id_user'];
        $item = $_POST['item'];
        $photos = Model_Photo::getPhotosModel($id_user);
        $path = $photos->get_photo_path($item);
        echo $path;
    }
}