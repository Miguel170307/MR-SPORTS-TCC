<?php
class PedidoController {
    private $db;
    private $requestMethod;
    private $mesaId;

    private $pedido;

    public function __construct($db, $requestMethod, $mesaId) {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->mesaId = $mesaId;

        $this->pedido = new Pedido($db);
    }

    public function processRequest() {
        switch ($this->requestMethod) {
            case 'GET':
                $this->getPedidosByMesa();
                break;
            case 'POST':
                $this->createPedido();
                break;
            default:
                $this->notFoundResponse();
                break;
        }
    }

    private function getPedidosByMesa() {
        $this->pedido->mesa_id = $this->mesaId;
        $stmt = $this->pedido->readByMesa();
        $pedidos_arr = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $pedido_item = array(
                "id" => $id,
                "nome" => $nome,
                "preco" => $preco,
                "quantidade" => $quantidade,
                "subtotal" => $preco * $quantidade
            );
            array_push($pedidos_arr, $pedido_item);
        }
        
        http_response_code(200);
        echo json_encode($pedidos_arr);
    }

    private function createPedido() {
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->mesa_id) && !empty($data->produto_id) && !empty($data->quantidade)) {
            $this->pedido->mesa_id = $data->mesa_id;
            $this->pedido->produto_id = $data->produto_id;
            $this->pedido->quantidade = $data->quantidade;
            
            if ($this->pedido->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Pedido criado com sucesso."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Não foi possível criar o pedido."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Dados incompletos. Forneça mesa_id, produto_id e quantidade."));
        }
    }

    private function notFoundResponse() {
        http_response_code(404);
        echo json_encode(array("message" => "Rota não encontrada"));
    }
}
?>
