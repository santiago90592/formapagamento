<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

use App\Libraries\Token;

class Utilizador extends Entity
{
    
    protected $dates   = [
        'criado_em',
        'atualizado_em',
        'deletado_em',
    ];


    public function verificaPassword(string $password){

        return password_verify($password, $this->password_hash);
    }

    public function iniciaPasswordReset(){

        $token = new Token();

        $this->reset_token = $token->getValue();

        $this->reset_hash = $token->getHash();

        $this->reset_expira_em = date('Y-m-d H:i:s', time() + 7200); //Expira em 2horas
    }

    public function completaPasswordReset(){

        $this->reset_hash = null;
        $this->reset_expira_em = null;
    }
    
}
