<?php 
    class Post {
        private $conn;
        private $table = 'posts';

        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $created_at;
        public ?string $message;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function read()
        {
            $query = "SELECT
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM
                    {$this->table} p
                LEFT JOIN 
                    categories c ON p.category_id = c.id
                ORDER BY 
                    p.created_at DESC";
            
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
            $query = "SELECT
                    c.name as category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM
                    {$this->table} p 
                LEFT JOIN
                    categories c ON p.category_id = c.id
                WHERE 
                    P.id = :id
                LIMIT 1";


            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

            try {
                $stmt->execute();
                $count = $stmt->rowCount();
        
                if ($count == 0){
                    $this->message = "No post with ID {$this->id} found";
                    return false;
                }

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->id = $row['id'];
                $this->title = $row['title'];
                $this->body = $row['body'];
                $this->category_id = $row['category_id'];
                $this->category_name = $row['category_name'];

                return true;
            } catch(PDOException $e) {
                $this->message = $e->getMessage();
                return false;
            }
        }

        public function create()
        {
            $query = "INSERT INTO {$this->table}
                      (title, body, author, category_id)
                    VALUES
                      (:title, :body, :author, :category_id)";

            $stmt = $this->conn->prepare($query);

            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            $stmt->bindParam(":title", $this->title, PDO::PARAM_STR);
            $stmt->bindParam(":body", $this->body, PDO::PARAM_STR);
            $stmt->bindParam(":author", $this->author, PDO::PARAM_STR);
            $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);

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
            if (!$this->read_single()) {
                $this->message = "Post with ID {$this->id} not found";
                return false;
            }

            $query = "DELETE FROM {$this->table} 
                WHERE id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

            try {
                $stmt->execute();
                return true;
            } catch (PDOException $e){
                $this->message = $e->getMessage();
                return false;
            }
        }

        public function update(){
            $query = "UPDATE {$this->table} 
                    SET
                        title = :title,
                        body = :body,
                        author = :author,
                        category_id = :category_id
                    WHERE
                        id = :id
                    ";

            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $this->title, PDO::PARAM_STR);
            $stmt->bindParam(":body", $this->body, PDO::PARAM_STR);
            $stmt->bindParam(":author", $this->author, PDO::PARAM_STR);
            $stmt->bindParam(":category_id", $this->category_id, PDO::PARAM_INT);
            $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

            try {
                $stmt->execute();
                return true;
            } catch(PDOException $e) {
                $this->message = $e->getMessage();
                return false;
            }

        }
    }