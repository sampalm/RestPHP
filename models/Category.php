<?php
    class Category {
        private $conn;
        private $table = "categories";

        public $id;
        public $name;
        public $created_at;
        public ?string $message;

        public function __construct($db) 
        {
            $this->conn = $db;
        }

        public function read()
        {
            $query = "SELECT c.id, c.name, c.created_at FROM {$this->table} c";

            $stmt = $this->conn->prepare($query);

            try {
                $stmt->execute();
                $count = $stmt->rowCount();

                if ($count == 0) {
                    $this->message = "No categories found";
                }

                return $stmt;
            } catch(PDOException $e) {
                $this->message = $e->getMessage();
            }
        }

        public function read_single()
        {
            $query = "SELECT c.id, c.name, c.created_at
                    FROM 
                        {$this->table} c
                    WHERE
                        c.id = :id
                    LIMIT
                        1";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT); 

            try {
                $stmt->execute();
                $count = $stmt->rowCount();

                if ($count == 0) {
                    $this->message = "No categories with ID {$this->id} found";
                    return false;
                }

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->name = $row['name'];
                $this->created_at = $row['created_at'];

                return true;
            } catch(PDOException $e) {
                $this->message = $e->getMessage();
                return false;
            }
        }

        public function create()
        {
            $query = "INSERT INTO {$this->table}
                        (name)
                    VALUES
                        (:name)";
            
            $this->name = htmlspecialchars(strip_tags($this->name));
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);

            try {
                $stmt->execute();
                return true;
            } catch(PDOException $e) {
                $this->message = $e->getMessage();
                return false;
            }
        }

        public function delete()
        {
            if(!$this->read_single()){
                $this->message = "Category with ID {$this->id} not found";
                return false;
            }

            $query = "DELETE FROM {$this->table} WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);   

            try {
                $stmt->execute();
                return true;
            } catch(PDOException $e) {
                $this->message = $e->getMessage();
                return false;
            }
        }

        public function update()
        {
            $query = "UPDATE {$this->table}
                    SET 
                        name = :name
                    WHERE 
                        id = :id";

            $this->name = htmlspecialchars(strip_tags($this->name));

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);        
            $stmt->bindParam(":name", $this->name, PDO::PARAM_STR);        

            try {
                $stmt->execute();
                return true;
            } catch(PDOException $e) {
                $this->message = $e->getMessage();
                return false;
            }
        }
    }