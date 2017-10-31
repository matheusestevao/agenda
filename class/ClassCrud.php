<?php
session_start();

class CrudDb
{
    public function insertRegistry($pdo,$tbl)
    {
        //VALIDATE EMAIL
        $sql = "SELECT * FROM {$tbl} WHERE email = ?";
        $validate = $pdo->prepare($sql);
        $validate->execute(array($_POST['email']));
        $row = $validate->rowCount();

        $people = $validate->fetch(\PDO::FETCH_OBJ);

        if ($row > 0) {

            $_SESSION['errorValidate'] = 1;

        } else {

            $sql = "INSERT INTO {$tbl} SET name = ?, email = ?, zip = ?, address = ?, num = ?, complement = ?, neighborhood = ?, county = ?, state = ?, created_on = ?";
            $insertPeople = $pdo->prepare($sql);
            $accept = $insertPeople->execute(array($_POST['name'],$_POST['email'],$_POST['zip'],$_POST['address'],$_POST['number'],$_POST['complement'],$_POST['neighborhood'],$_POST['county'],$_POST['state'],date('Y-m-d H:i:s')));

            if (!$accept) {

                $_SESSION['errorDb'] = $insertPeople->errorInfo();

            } else {

                $idPeople = $pdo->lastInsertId();
                
                unset($_POST['insertPhonePeople_idComponent']['X']);

                foreach ($_POST['insertPhonePeople_idComponent'] as $key => $value) {

                    $sql = "INSERT INTO people_phone SET id_people = ?, phone = ?, type_phone = ?";
                    $phone = $pdo->prepare($sql);
                    $phone->execute(array($idPeople,$_POST['insertPhonePeople_numberPhone'][$key],$_POST['insertPhonePeople_typePhone'][$key]));

                }
                
                $_SESSION['successInsert'] = 1;

            }
        }   

    }

    public function selectRegistry($pdo,$idPeople,$tbl)
    {
        $sql = "SELECT * FROM {$tbl} WHERE id_people = ?";
        $selectPeople = $pdo->prepare($sql);
        $selectPeople->execute(array($idPeople));
        $row = $selectPeople->fetch(\PDO::FETCH_OBJ);

        return $row;
    }

    public function selectPhone($pdo,$idPeople)
    {
        $sql = "SELECT * FROM people_phone WHERE id_people = ?";
        $selectPhone = $pdo->prepare($sql);
        $selectPhone->execute(array($idPeople));

        $phone = $selectPhone->fetchAll(\PDO::FETCH_OBJ);

        return $phone;
    }

    public function selectList($pdo,$tbl)
    {
        $sql = "SELECT * FROM {$tbl}";
        $listPeople = $pdo->prepare($sql);
        $listPeople->execute();

        $peopleAll = $listPeople->fetchAll(\PDO::FETCH_OBJ);

        return $peopleAll;
    }

    public function updateRegistry($pdo,$tbl)
    {
        $sql = "UPDATE {$tbl} SET name = ?, email = ?, zip = ?, address = ?, num = ?, complement = ?, neighborhood = ?, county = ?, state = ?, lastedit_on = ? WHERE id_people = {$_POST['idPeople']}";
        $up = $pdo->prepare($sql);
        $accpetUp = $up->execute(array($_POST['name'],$_POST['email'],$_POST['zip'],$_POST['address'],$_POST['number'],$_POST['complement'],$_POST['neighborhood'],$_POST['county'],$_POST['state'],date('Y-m-d H:i:s')));

        if (!$accpetUp) {

            $_SESSION['errorDb'] = $up->errorInfo();

        } else {

            $idPeople = $_POST['idPeople'];
            unset($_POST['insertPhonePeople_idComponent']['X']);

            $ids = Array();

            foreach ($_POST['insertPhonePeople_idComponent'] as $key => $value) {

                $idPhonePeople = ($value > 0 ? $value : null);

                if ($idPhonePeople > 0) {

                    $sql = "UPDATE people_phone SET phone = ?, type_phone = ? WHERE id_phone = {$idPhonePeople}";
                    $upPhone = $pdo->prepare($sql);
                    $upPhone->execute(array($_POST['insertPhonePeople_numberPhone'][$key],$_POST['insertPhonePeople_typePhone'][$key]));

                    $ids[] = $idPhonePeople;

                } else {

                    $sql = "INSERT INTO people_phone SET id_people = ?, phone = ?, type_phone = ?";
                    $phone = $pdo->prepare($sql);
                    $phone->execute(array($idPeople,$_POST['insertPhonePeople_numberPhone'][$key],$_POST['insertPhonePeople_typePhone'][$key]));

                    $ids[] = $pdo->lastInsertId();

                }

            }

            if (is_array($ids) && sizeof($ids) > 0) {

                $sql = "DELETE FROM people_phone WHERE id_people = ? AND id_phone NOT IN (".implode(',', $ids).")";
                $delPhone = $pdo->prepare($sql);
                $delPhone->execute(array($idPeople));

            } else {

                $sql = "DELETE FROM people_phone WHERE id_people = ?";
                $delPhone = $pdo->prepare($sql);
                $delPhone->execute(array($idPeople));

            }

            $_SESSION['successUp'] = 1;

        }

    }

    public function deleteRegistry($pdo,$tbl,$idPeople)
    {

        $sql = "SELECT * FROM people_phone WHERE id_people = ?";
        $val = $pdo->prepare($sql);
        $val->execute(array($idPeople));
        $row = $val->fetchAll(\PDO::FETCH_OBJ);

        if ($row > 0) {

            $sql = "DELETE FROM people_phone WHERE id_people = ?";
            $delPhone = $pdo->prepare($sql);
            $delPhone->execute(array($idPeople));

            $sql = "DELETE FROM {$tbl} WHERE id_people = ?";
            $del = $pdo->prepare($sql);
            $infoDel = $del->execute(array($idPeople));

            if (!$infoDel){
                
                $_SESSION['errorDb'] = $del->errorInfo();
            
            } else {
                
                $_SESSION['successDel'] = 1;

            }

        } else {

            $sql = "DELETE FROM {$tbl} WHERE id_people = ?";
            $del = $pdo->prepare($sql);
            $infoDel = $del->execute(array($idPeople));

            if (!$infoDel){
                
                $_SESSION['errorDb'] = $del->errorInfo();
            
            } else {
                
                $_SESSION['successDel'] = 1;

            }
        }
    }
}
