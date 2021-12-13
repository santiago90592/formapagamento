<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

use App\Entities\FormaPagamento;

class FormasPagamento extends BaseController
{
    private $formapagamentoModel;

    public function __construct(){

        $this->formaPagamentoModel = new \App\Models\FormaPagamentoModel();
    }

    public function index(){

        $data = [
            'titulo' => 'Listando as formas de pagamento',
            'formas' => $this->formaPagamentoModel->withDeleted(true)->paginate(10),
            'pager' => $this->formaPagamentoModel->pager,
        ];

        return view('Admin/FormasPagamento/index', $data);

        
    }

     public function procurar(){

        if(!$this->request->isAJAX()){

            exit('Pagina não encontrada');
        }

        $formas = $this->formaPagamentoModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($formas as $forma){

            $data['id'] = $forma->id;
            $data['value'] = $forma->nome;

            $retorno[] = $data;
        }

        return $this->response->setJSON($retorno);
    }

    public function show($id = null){

        $formaPagamento = $this->buscaFormaPagamentoOu404($id);

        $data = [
            'titulo' => "Detalhando a forma de pagamento $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        return view('Admin/FormasPagamento/show', $data);
    }

    public function editar($id = null){

        $formaPagamento = $this->buscaFormaPagamentoOu404($id);

        $data = [
            'titulo' => "Editando a forma de pagamento $formaPagamento->nome",
            'forma' => $formaPagamento,
        ];

        return view('Admin/FormasPagamento/editar', $data);
    }



    /**
     * 
     * @param int $id
     * @return objeto formapagamento
     */
    private function buscaFormaPagamentoOu404(int $id = null){

        if (!$id || !$formaPagamento = $this->formaPagamentoModel->withDeleted(true)->where('id', $id)->first()) {
            
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a forma de pagamento $id");
        }

        return $formaPagamento;

    }
}
