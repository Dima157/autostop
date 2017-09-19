<?php
class Model_Photo extends Model{
    private $id, $id_photos = [], $photos = [], $comments = [];
    static $db;
    function __construct($id = null,$id_photos = null,$photos = null, $comments = null)
    {
        parent::__construct();
        $this->id = $id;
        $this->id_photos = $id_photos;
        $this->photos = $photos;
        $this->comments = $comments;
    }

    static function  getPhotosModel($id){
        $db = DB::PDO();
        $query = "select * from photos where fk_user='$id'";
        $id_photos = [];
        $photos = [];
        $comments = [];
        //$res = $db->query($query);
        $res = $db->select('images', 'fk_user', $id);
        if($res){
            //$res = $res->fetchAll();
            $count = count($res);
            for($i = 0; $i < $count; $i++){
                $photos[] = $res[$i]['path'];
            }
            for($i = 0; $i < $count; $i++){
                $comments[] = $res[$i]['comment'];
            }
            for($i = 0; $i < $count; $i++){
                $id_photos[] = $res[$i]['id_images'];
            }
            return new Model_Photo($id, $id_photos, $photos, $comments);
        }
        return new Model_Photo();
    }

    function getPath($id_photos){
        for($i = 0; $i < count($this->id_photos); $i++){
            if($id_photos == $this->id_photos[$i]){
                return $this->photos[$i];
            }
        }

    }

    function getJsonPath(){
        return json_encode(['photo' => $this->photos]);
    }

    /**
     * @return array
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param array $photo
     */
    public function setPhotos($photo)
    {
        $query = "select path from photos where fk_user='$this->id'";
        //$res = $this->pdo->query($query)->fetchAll();
        $res = $this->pdo->select('images', 'fk_user', $this->id);
        if($res){
            for($i = 0; $i < count($res); $i++){
                $this->photos[] = $res[$i]['path'];
            }
        }
    }

    /**
     * @return array
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param array $comments
     */
    public function setComments()
    {
        $query = "select comment from images where fk_user='$this->id'";
        //$res = $this->pdo->query($query)->fetchAll();
        $res = $this->pdo->select('images', 'fk_user', $this->id);
        if($res){
            for($i = 0; $i < count($res); $i++){
                $this->photos[] = $res[$i]['comment'];
            }
        }
    }

    function getCountPhotos(){
        return count($this->photos);
    }

    function get_photo_path($num){
        $photos = array_reverse($this->photos);
        return $photos[$num];
    }

    function getUploadFile(){
        $query = "select * from images ORDER BY id_images DESC LIMIT 1";
        //$res = $this->pdo->query($query)->fetchAll();
        $res = $this->pdo->selectLastElement('images', 'id_images');
        $size = getimagesize($res[0]['path']);
        $width = $size[0];
        if($width > 300) $width = 300;
        return [$res[0]['id_images'], $res[0]['path'], $width];
    }

    function uplodPhotos($tmp_name, $name, $login){
        $nameDir = "images/$login";
        if(!is_dir($nameDir)){
            mkdir($nameDir, 0700);
        }
        $fk_user = $_SESSION['id'];
        if(!is_array($tmp_name)) {
            move_uploaded_file($tmp_name, "$nameDir/$name");
            $mass = [
                'path' => $nameDir . '/' . $name,
                'comment' => '',
                'fk_user' => $fk_user
            ];
            $this->pdo->insert('images', $mass);
            return "$nameDir/$name";
        }else{
            $res = [];
            for($i = 0; $i < count($tmp_name); $i++){
                move_uploaded_file($tmp_name[$i], "$nameDir/$name[$i]");
                $mass = [
                    'path' => $nameDir . '/' . $name[$i],
                    'comment' => '',
                    'fk_user' => $fk_user
                ];
                $this->pdo->insert('images', $mass);
                $res[] = "$nameDir/$name[$i]";
            }
            return $res;
        }
    }

    function showPhoto($limit = null){
//        $res = $this->pdo->selectLimit('images', $start, $limit);
        if($limit != null) {
            $start = count($this->photos) - 6;
            $res = array_slice($this->photos, $start, $limit);
            $res = array_reverse($res);
        }else{
            $res = array_slice($this->photos, 0);
            $res = array_reverse($res);
        }
        return $res;
    }



}