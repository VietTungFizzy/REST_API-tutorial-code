<?php
    class Post {
        //DB related attributes
        private $connect;
        private $table = 'posts';

        //Post attributes
        public $id;
        public $category_id;
        public $category_name;
        public $title;
        public $body;
        public $author;
        public $create_at;

        //Instantiate Post instance
        //
        // @params: PDO
        public function __construct($db) {
            $this->connect = $db;
        }

        // Read all record from posts table
        //
        // @params:
        //
        // @return: PDOStatement
        public function read() {
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                '. $this->table .' p 
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC';

            $statement = $this->connect->prepare($query);
            $statement->execute();
            return $statement;
        }

        // Read single record from posts table
        // And set attribute of record to attribute of this class
        public function read_single() {
            $query = 'SELECT 
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                '. $this->table .' p 
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE
                p.id = ? 
            LIMIT 0,1';

            $statement = $this->connect->prepare($query);
            $statement->bindParam(1, $this->id);
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            //Set properties
            $this->title = $row['title'];
            $this->body = $row['body'];
            $this->author = $row['author'];
            $this->category_id = $row['category_id'];
            $this->category_name = $row['category_name'];
        }

        //Create a record in posts table
        //
        //@return: boolean
        public function create() {
            //Create query
            $query = 'INSERT INTO '. 
                $this->table. '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id';
            
            $statement = $this->connect->prepare($query);

            //Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            //Bind data
            $statement->bindParam(':title', $this->title);
            $statement->bindParam(':body', $this->body);
            $statement->bindParam(':author', $this->author);
            $statement->bindParam(':category_id', $this->category_id);

            //Execute query
            if($statement->execute()){
                return true;
            }

            //Print error
            printf("Error: %s.\n", $statement->error);
            return false;
        }

         //Update a record in posts table
        //
        //@return: boolean
        public function update() {
            //Update query
            $query = 'UPDATE '. 
                $this->table. '
            SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id,
            WHERE
                id = :id';
            
            $statement = $this->connect->prepare($query);

            //Clean data
            $this->title = htmlspecialchars(strip_tags($this->title));
            $this->body = htmlspecialchars(strip_tags($this->body));
            $this->author = htmlspecialchars(strip_tags($this->author));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));
            $this->id = htmlspecialchars(strip_tags($this->id));

            //Bind data
            $statement->bindParam(':title', $this->title);
            $statement->bindParam(':body', $this->body);
            $statement->bindParam(':author', $this->author);
            $statement->bindParam(':category_id', $this->category_id);
            $statement->bindParam(':id', $this->id);

            //Execute query
            if($statement->execute()){
                return true;
            }

            //Print error
            printf("Error: %s.\n", $statement->error);
            return false;
        }

        //Delete a record in posts table
        //
        //@return: boolean
        public function delete() {
            $query = 'DELETE FROM '.$this->table.' WHERE id = :id';

            $statement = $this->connect->prepare($query);

            //Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            
            //Bind data
            $statement->bindParam(':id', $this->id);

             //Execute query
             if($statement->execute()){
                return true;
            }

            //Print error
            printf("Error: %s.\n", $statement->error);
            return false;
        }
    }
?>