<?php 

namespace App\Models;

//Use abstract class for models
use MF\Model\Model;

//User's class
class Tweet extends Model{
    private $id, $id_user, $username, $text, $date;

    public function __get($attr){
        return $this->$attr;
    }

    public function __set($attr, $value){
        $this->$attr = $value;
    }

    //add new tweet
    public function addTweet(){
        $query = "insert into tb_tweets(id_user, text) values (:id_user, :text)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_user', $this->__get('id_user'));
        $stmt->bindValue(':text', $this->__get('text'));
        $stmt->execute();
        return $this;
    }

    //delete a tweet
    public function deleteTweet(){
        $query = "delete from tb_tweets where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id'));
        $stmt->execute();
        return $this;
    }

    //get all tweet for timeline
    public function getAllTweets(){
        $query = "select tweet.id as id, tweet.id_user as id_user, user.name as username, tweet.text text, tweet.date date from tb_tweets as tweet
                left join tb_users user on user.id = tweet.id_user
                where
                    tweet.id_user = :id
                    or tweet.id_user in (select id_followed from tb_following where id_follower = :id)
                order by date desc";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->__get('id_user'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}

?>