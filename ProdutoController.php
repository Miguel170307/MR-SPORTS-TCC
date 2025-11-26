<?php
class ProdutoController {
    private $db;
    private $requestMethod;
    private $produtoId;

    private $produto;

    public function __construct($db, $requestMethod, $produtoId) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->produtoId = $produtoId;

        $this->produto = new Produto($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->produtoId) {
                    $this->getProduto($this->produtoId);
                } else {
                    $this->getAllProdutos();
                }
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    private function getAllProdutos() {
        $stmt = $this->produto->read();
        $produtos_arr = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $produto_item = array(
                "id" => $id,
                "nome" => $nome,
                "preco" => $preco
            );
            array_push($produtos_arr, $produto_item);
        }
        
        http_response_code(200);
        echo json_encode($produtos_arr);
    }

    private function getProduto($id) {
        $this->produto->id = $id;
        $this->produto->readOne();
        
        if($this->produto->nome != null) {
            $produto_arr = array(
                "id" => $this->produto->id,
                "nome" => $this->produto->nome,
                "preco" => $this->produto->preco
            );
            http_response_code(200);
            echo json_encode($produto_arr);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Produto não encontrado."));
        }
    }

    private function notFoundResponse() {
        http_response_code(404);
        echo json_encode(array("message" => "Rota não encontrada"));
    }
}
?>
