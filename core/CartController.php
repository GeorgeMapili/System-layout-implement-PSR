<?php

namespace Core;

use Includes\Database;
use Ramsey\Uuid\Uuid;
use PDO;

class CartController
{

    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function create_cart(string $user_id, int $food_id, string $quantity, int $price)
    {
        $uuid = Uuid::uuid4();
        $uuid->toString();
        $uuid->getFields()->getVersion();

        $user_id = \htmlspecialchars(strip_tags($user_id));
        $food_id = \htmlspecialchars(strip_tags($food_id));
        $quantity = \htmlspecialchars(strip_tags($quantity));
        $price = \htmlspecialchars(strip_tags($price));

        $query = "INSERT INTO carts(id, user_id, food_id, quantity, price)VALUES(:id, :user_id, :food_id, :quantity, :price)";

        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(":id", $uuid, PDO::PARAM_STR);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        $stmt->bindParam(":food_id", $food_id, PDO::PARAM_STR);
        $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
        $stmt->bindParam(":price", $price, PDO::PARAM_STR);

        if($stmt->execute()):
            return true;
        else:
            return false;
        endif;

    }

    public function cart_list(string $user_id)
    {
        $query = "SELECT * FROM carts WHERE user_id = :user_id ORDER BY created_at DESC";

        $stmt = $this->db->connect()->prepare($query);
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
        
        if($stmt->execute()):
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        else:
            return false;
        endif;

    }

}