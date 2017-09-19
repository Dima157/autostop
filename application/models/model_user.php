<?php
class Model_User extends Model
{
    private $id, $name, $surname, $birthday, $city, $email, $avatar, $photos, $account;

    function __construct($id = null, $name = null, $surname = null, $city = null, $email = null, $birthday = null, $avatar = null, $photos = null)
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->city = $city;
        $this->email = $email;
        $this->birthday = $birthday;
        $this->avatar = $avatar;
        $this->photos = $photos;

    }

    static function getUser($id)
    {
        $db = DB::PDO();
        //$query = "select * from Users where id='id'";
        //$res = $db->query($query)->fetchAll();
        $avatar = Model_Avatar::getAvatar($id);
        $photos = Model_Photo::getPhotosModel($id);
        $res = $db->select('users', 'id', $id);
        if (count($res) > 0) {
            return new Model_User($id, $res[0]['name'], $res[0]['surname'], $res[0]['city'], $res[0]['email'], $res[0]['birthday'], $avatar, $photos);
        }
    }

    function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return array
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }


    function getMyAutostop()
    {
        $mass = [];
        $res = $this->pdo->select('participants', 'fk_user', $this->id);
        $mass_group = [];
        for($i = 0; $i < count($res); $i++){
            $mass_group[] = $res[$i]['fk_group'];
        }
        $res = $this->pdo->select('groups', 'creator_id', $this->id);
        for($i = 0; $i < count($res); $i++){
            $mass_group[] = $res[$i]['id_group'];
        }
        return $mass_group;
    }


}

