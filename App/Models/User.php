<?php 

namespace App\Models;

//Use abstract class for models
use MF\Model\Model;

//User's class
class User extends Model{
    private $id, $name, $email, $pass, $searchUser, $id_followed;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    //Register new user
    public function register(){
        $query = "insert into tb_users(name, email, pass) values(:name, :email, :pass)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $this->__get('name'));
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':pass', md5($this->__get('pass')));
        $stmt->execute();
        return $this;
    }

    //Validate user
    public function validateUser(){
        $is_valid = true;
        if(strlen($this->__get('name')) < 3){
            $is_valid = false;
        }
        if(strlen($this->__get('email')) < 3){
            $is_valid = false;
        }
        if(strlen($this->__get('pass')) < 6 || strlen($this->__get('pass')) > 20){
            $is_valid = false;
        }
        return $is_valid;
    }

    //Get user by email | check if email is avaliable
    public function getUserByEmail(){
        $query = "select name, email from tb_users where email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Verify if the user exists
    public function login(){
        $query = "select id, name, email from tb_users where email = :email and pass = :pass";
		$stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':pass', md5($this->__get('pass')));
		$stmt->execute();

		$user = $stmt->fetch(\PDO::FETCH_ASSOC);

		if($user['id'] != '' && $user['name'] != '') {
			$this->__set('id', $user['id']);
			$this->__set('name', $user['name']);
		}

		return $this;
    }

    //Getting all users
    public function getAllUsers(){
        $query = "
        select 
            user.id as id, 
            user.name as name, 
            user.email as email,
            (
                select
                    count(*)
                from
                    tb_following as follow 
                where
                    follow.id_follower = :id_follower and follow.id_followed = user.id
            ) as isfollowing
        from 
            tb_users user 
        where 
            user.id <> :id_follower
        order by 
            user.name";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_follower', $this->__get('id'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Getting users by name or email
    public function getUsers(){
        $query = "
            select 
                user.id as id, 
                user.name as name, 
                user.email as email,
                (
					select
						count(*)
					from
						tb_following as follow 
					where
						follow.id_follower = :id_follower and follow.id_followed = user.id
				) as isfollowing
            from 
                tb_users user
            where 
                user.id <> :id_follower and (user.name like :name or user.email like :email)  
            order by 
                user.name";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_follower', $this->__get('id'));
        $stmt->bindValue(':name', '%'.$this->__get('searchUser').'%');
        $stmt->bindValue(':email', '%'.$this->__get('searchUser').'%');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    //Follow other users
    public function follow(){
        $query = "insert into tb_following(id_follower, id_followed) values (:id_follower, :id_followed)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_follower', $this->__get('id'));
        $stmt->bindValue(':id_followed', $this->__get('id_followed'));
        $stmt->execute();
        return $this;
    }

    //Unfollow other users
    public function unfollow(){
        $query = "delete from tb_following where id_follower = :id_follower and id_followed = :id_followed";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_follower', $this->__get('id'));
        $stmt->bindValue(':id_followed', $this->__get('id_followed'));
        $stmt->execute();
        return $this;
    }

    //Getting username
    public function getName(){
        $query = "select name from tb_users where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //Get count tweets
    public function countTweets(){
        $query = "select count(*) as countTweets from tb_tweets where id_user = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //Get count following
    public function countFollowing(){
        $query = "select count(*) as countFollowing from tb_following where id_follower = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    //Get count following
    public function countFollows(){
        $query = "select count(*) as countFollows from tb_following where id_followed = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}

?>