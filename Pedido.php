<?php
class Pedido {
    private $conn;
    private $table_name = "pedidos";

    public $id;
    public $mesa_id;
    public $produto_id;
    public $quantidade;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET mesa_id=:mesa_id, produto_id=:produto_id, quantidade=:quantidade";
        
        $stmt = $this->conn->prepare($query);
        
        $this->mesa_id = htmlspecialchars(strip_tags($this->mesa_id));
        $this->produto_id = htmlspecialchars(strip_tags($this->produto_id));
        $this->quantidade = htmlspecialchars(strip_tags($this->quantidade));
        
        $stmt->bindParam(":mesa_id", $this->mesa_id);
        $stmt->bindParam(":produto_id", $this->produto_id);
        $stmt->bindParam(":quantidade", $this->quantidade);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readByMesa() {
        $query = "SELECT p.id, pr.nome, pr.preco, p.quantidade 
                  FROM " . $this->table_name . " p
                  JOIN produtos pr ON p.produto_id = pr.id
                  WHERE p.mesa_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->mesa_id);
        $stmt->execute();
        return $stmt;
    }
}
?>
