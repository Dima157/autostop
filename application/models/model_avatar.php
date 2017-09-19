<?php
class Model_Avatar extends Model{
    private $id, $left , $top, $photo_id, $width;
    function __construct($id = null, $left = null, $top = null, $photo_id = null, $width = null)
    {
        parent::__construct();
        $this->id = $id;
        $this->photo_id = $photo_id;
         $this->left = $left;
        $this->top = $top;
        $this->width = $width;
    }

    function insert(){
        //$query = "slect id_images from images ORDER BY id_images DESC LIMIT 1";
        //$res = $this->pdo->query($query)->fetchAll();
        //$id = $res[0]['id_images'];
        //$this->photo_id = $id;
        $id = $this->pdo->selectLastElement('images', 'id_images');
        $id = $id[0]['id_images'];
        //$query = "insert into avatar(photo_id, left, top, fk_user)values('$this->photos_id', '$this->left', '$this->top', '$this->id')";
        $mass = [
            'photo_id' => $this->photo_id,
            'left' => $this->left,
            'top' => $this->top,
            'fk_user' => $this->id
        ];
        $this->pdo->insert('avatar', $mass);
        //$this->pdo->query($query);
    }

    /**
     * @return mixed
     */
    public function getLeft()
    {
        return $this->left[count($this->left) - 1];
    }

    /**
     * @return mixed
     */
    public function getTop()
    {
        return $this->top[count($this->top) - 1];
    }

    /**
     * @return mixed
     */
    public function getPath($photo)
    {
        //$query = "select fk_photo from avatar ORDER BY id_avatar DESC LIMIT 1";
        //var_dump($photo);
        $res = $this->pdo->selectLastElement('avatar', 'id_avatar');
        if($res){
            //$res = $res->fetchAll();
            $id_photos = $res[0]['fk_photo'];
            $path = $photo->getPath($this->getLast());
            return $path;
        }
        return false;
    }

    static function getAvatar($id){
        $db = DB::PDO();
        //echo $id;
        $query = "select*from avatar where fk_user='$id'";
        $res = $db->select('avatar', 'fk_user', $id);
        $photo_id = [];
        $path = [];
        $left = [];
        $top = [];
        $width = [];
        for($i = 0; $i < count($res); $i++){
            $photo_id[] = $res[$i]['photo_id'];
            //$path[] = $res[$i]['path'];
            $left[] = $res[$i]['leftPosition'];
            $top[] = $res[$i]['topPosition'];
            $width[] = $res[$i]['width'];
        }
        if($res){
            return new Model_Avatar($id, $left, $top, $photo_id, $width);
        }
        return false;
    }

    function getLast(){
        return $this->photo_id[count($this->photo_id) - 1];
    }

    function getWidth(){
        return $this->width[count($this->width) - 1];
    }

    function insertAvatar($id_photo, $left, $top, $width){
        $mass = [
            'photo_id' => $id_photo,
            'leftPosition' => $left,
            'topPosition' => $top,
            'width' => $width,
            'fk_user' => $_SESSION['id']
        ];

        $this->pdo->insert('avatar', $mass);
        //$this->pdo
    }
}