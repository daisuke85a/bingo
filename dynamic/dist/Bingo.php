<?php

namespace MyApp;

class Bingo
{
    private $_db;

    public function __construct()
    {
        try {
            $this->_db = new \PDO(DSN, DB_USERNAME, DB_PASSWORD);
            $this->_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function getMaxRank(){
        $stmt = $this->_db->prepare("SELECT MAX( rank ) FROM bingorank");
        $stmt->execute();
        $rank = $stmt->fetchAll();

        if(isset($rank[0]["MAX( rank )"])){
            return $rank[0]["MAX( rank )"];
        }
        else{
            return 0;
        }
    }

    public function addUser($name, $num1, $num2, $num3, $num4, $num5)
    {

        //バリデーションチェック(num1からnum5が超ふきしていないかチェックする)
        $numbers = array($num1, $num2, $num3, $num4, $num5);
        //var_dump($numbers);
        if ($numbers === array_unique($numbers)) {
            //重複なし
            //echo "OK!";
        } else {
            //重複あり
            echo "ユーザー登録失敗! 番号が重複しています";
            return;
        }

        //todo:バリデーションチェック 同じユーザー名だったら登録不可にする
        $users = $this->getAllUsers();

        foreach ($users as $user) {
            if ($user["name"] === $name) {
                echo "ユーザー登録失敗! 同じ名前の人が居ます";
                return;
            }
        }
        //var_dump($users);

        //ユーザー登録
        try {
            $stmt = $this->_db->prepare("INSERT INTO users ( name, num1,num2,num3,num4,num5) VALUES (:name, :num1, :num2, :num3, :num4, :num5)");
            $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
            $stmt->bindParam(':num1', $num1, \PDO::PARAM_INT);
            $stmt->bindParam(':num2', $num2, \PDO::PARAM_INT);
            $stmt->bindParam(':num3', $num3, \PDO::PARAM_INT);
            $stmt->bindParam(':num4', $num4, \PDO::PARAM_INT);
            $stmt->bindParam(':num5', $num5, \PDO::PARAM_INT);
            $stmt->execute();

            $value = 'something from somewhere';
            setcookie("name", $name, time() + 3600 + 3600 + 3600); /* 有効期限は3時間です */
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

    }

    public function getAllUsers()
    {
        $stmt = $this->_db->query("select * from users order by id asc");
        //return $stmt->fetchAll(\PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }

    public function getAll()
    {
        $stmt = $this->_db->query("select * from numbers order by id desc");
        //return $stmt->fetchAll(\PDO::FETCH_OBJ);
        return $stmt->fetchAll();
    }

    public function insertNum($num)
    {
        try {
            $stmt = $this->_db->prepare("INSERT INTO numbers (number) VALUES (:number)");
            $stmt->bindParam(':number', $num, \PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getRank($name){
        try {
            // $stmt = $this->_db->prepare("SELECT MAX( rank ) FROM bingorank");
            // $stmt->execute();
            // $rank = $stmt->fetchAll();

            // echo "rank<br>";
            // var_dump($rank);

            $stmt = $this->_db->prepare("SELECT * FROM bingorank WHERE name = :name");
            $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
            $stmt->execute();
            $record = $stmt->fetchAll();

            // var_dump($record);
            // var_dump(isset($record));

            if(empty($record) !== true){
                 //すでにビンゴ済みだったら
                // var_dump($record);
                return $record[0]["rank"];
            }else{
                // var_dump($record);
                return 0;
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function checkBingo($name)
    {
        try {
            //すでにビンゴ済みだったら
            $stmt = $this->_db->prepare("SELECT * FROM bingorank WHERE name = :name");
            $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
            $stmt->execute();
            $record = $stmt->fetchAll();

            if(isset($record[0]) !== false){
                //echo "すでにビンゴ済み";
                return false;
            }else{
                //echo "未ビンゴ";
            }

            $stmt = $this->_db->prepare("SELECT * FROM users WHERE name = :name");
            $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
            $stmt->execute();

            $record = $stmt->fetchAll();

            // $stmt = $this->_db->prepare("SELECT * FROM numbers");
            // $stmt->execute();

            $stmt = $this->_db->query("select * from numbers order by id desc");
            //return $stmt->fetchAll(\PDO::FETCH_OBJ);
            $numbers = $stmt->fetchAll();

            //最初はすべて0で初期化（全部1になったらビンゴ！）
            $hit = array(0, 0, 0, 0, 0);

            $card = array($record[0]["num1"], $record[0]["num2"], $record[0]["num3"], $record[0]["num4"], $record[0]["num5"]);
            foreach ($numbers as $number) {
                for ($i = 0; $i < 5; $i++) {
                    if ($number["number"] === $card[$i]) {
                        $hit[$i] = 1;
                    }
                }
            }

            $result = true;
            for ($i = 0; $i < 5; $i++) {
                if ($hit[$i] === 0) {
                    $result = false;
                }
            }

            //ビンゴした場合
            if( $result ){
              $newrank = $this->getMaxRank() + 1;
              //var_dump($newrank);
              $stmt = $this->_db->prepare("INSERT INTO bingorank (name , rank ) VALUES (:name ,:rank)");
              $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
              $stmt->bindParam(':rank', $newrank, \PDO::PARAM_INT);
              $stmt->execute();
              echo $name . "さん、ビンゴです！</br>";
              //var_dump($newrank);
            }else{
                echo $name . "さん、まだビンゴしていませんよ！</br>";
            }
            // echo "<br>result" . var_export( $result, true ) . "<br>";

            return $result;

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function resetNum()
    {
        try {
            $sql = 'DELETE FROM numbers';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function resetUser()
    {
        try {
            $sql = 'DELETE FROM users';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();
            // クッキーを削除する（有効期限を現在時刻より前にすると、ブラウザが削除してくれる）
            setcookie("name", "", time() - 3600);

            $sql = 'DELETE FROM bingorank';
            $stmt = $this->_db->prepare($sql);
            $stmt->execute();

            // クッキーを削除する（有効期限を現在時刻より前にすると、ブラウザが削除してくれる）
            setcookie("name", "", time() - 3600);
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
