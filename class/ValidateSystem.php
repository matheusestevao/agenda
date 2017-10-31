<?php

class ValidateSystem
{

    public function validateEmail($pdo,$email)
    {
        $back = Array();

        $sql = "SELECT * FROM people WHERE email = ?";
        $validate = $pdo->prepare($sql);
        $validate->execute(array($email));
        $row = $validate->rowCount();

        $people = $validate->fetch(\PDO::FETCH_OBJ);

        if ($row > 0) {
            $back['idPeople'] = $people->id_people;
            $back['validate'] = 1;
        } else {
            $back['validate'] = 0;
        }


        return ($back);

    }

    public function searchZip($zip)
    {
        $reg = simplexml_load_file("http://viacep.com.br/ws/".$zip."/xml"); 
        
        if (!isset($reg->erro)) { 

                $dados['success']      = 1;
                $dados['address']      = (string) $reg->logradouro;
                $dados['neighborhood'] = (string) $reg->bairro;
                $dados['county']       = (string) $reg->localidade;
                $dados['state']        = (string) $reg->uf;
                
                return ($dados);
    
        } else {

            $dados['sucesso'] = 0; 
                
            return ($dados);
                
        }
    }

}