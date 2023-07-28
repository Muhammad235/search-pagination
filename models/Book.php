<?php


require 'config/Database.php';

// book.php
class Book
{

    private $conn;
    private $table_name;

    //constructor
    public function __construct($db) {
        $this->conn = $db;
        $this->table_name = "books";
    }

    public function get_total_rows($search_query) {
    
        // Prepare the SQL statement with placeholders
        $sql = "SELECT COUNT(*) as numrows FROM " . $this->table_name . " WHERE title LIKE ? OR author LIKE ?";
    
        $stmt = $this->conn->prepare($sql);
    
        // Bind parameters to the prepared statement
        $search_param = "%" . $search_query . "%";
        $stmt->bind_param("ss", $search_param, $search_param);
    
        // Execute the prepared statement
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
    
        // Fetch the row as an associative array
        $row = $result->fetch_assoc();
    
        // Close the statement
        $stmt->close();
    
        // Return the total number of rows
        return $row['numrows'];
    }
    

    // public function get_search_result($page_number, $search_query) {
    
    //     // Setting the number of records per page
    //     $records_per_page = 5;
    
    //     // Calculating the start from value
    //     $start = ($page_number - 1) * $records_per_page;
    
    //     // Prepare the query with placeholders for bound parameters
    //     $query = "SELECT * FROM " . $this->table_name . " WHERE title LIKE ? OR author LIKE ? LIMIT ?, ?";
    //     $stmt = $this->conn->prepare($query);
    
    //     // Bind parameters to the prepared statement
    //     $search_param = "%" . $search_query . "%";
    //     $stmt->bind_param("ssii", $search_param, $search_param, $start, $records_per_page);
    
    //     // Execute the prepared statement
    //     $stmt->execute();
    
    //     // Get the result
    //     $result = $stmt->get_result();
    
    //     // Close the statement
    //     $stmt->close();
    
    //     return $result;
    // }


    public function get_search_result($page_number, $search_query) {
        // Assuming you have already established a database connection ($conn)
    
        // Setting the number of records per page
        $records_per_page = 5;
    
        // Calculating the start from value
        $start = ($page_number - 1) * $records_per_page;
    
        // Prepare the query with placeholders for bound parameters
        $query = "SELECT * FROM " . $this->table_name . " WHERE title LIKE ? OR author LIKE ? LIMIT ?, ?";
        $stmt = $this->conn->prepare($query);
    
        // Bind parameters to the prepared statement
        $search_param = "%" . $search_query . "%";
        $stmt->bind_param("ssii", $search_param, $search_param, $start, $records_per_page);
    
        // Execute the prepared statement
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
    
        // Close the statement
        $stmt->close();
    
        return $result;
    }
    
    
}
