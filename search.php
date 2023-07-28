<?php

require_once('models/Book.php');

//database object
$db = new Database();

$connection = $db->connect();

//Initialize the Book class
$search_book = new Book($connection);

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['q']) && isset($_GET['p'])) {

    // query parameters
    $search_query = htmlspecialchars($_GET['q']);
    $page_number = htmlspecialchars($_GET['p']);
    
    $data = $search_book->get_search_result($page_number, $search_query);

    $totalrows = $search_book->get_total_rows($search_query);
    $total_pages = ceil($totalrows / 5);

    if ($data->num_rows > 0) {

        $search_result["records"] = array();

        while ($row = $data->fetch_assoc()) {

            array_push($search_result["records"], array(

                "id" => $row['id'],
                "uuid" => $row['uuid'],
                "title" => $row['title'],
                "author" => $row['author']
            ));
        } 

        http_response_code(200); // Ok (success)

        echo json_encode(array(
            "status" => 200,
            "search_result" => $search_result["records"],
            "total_pages" => $total_pages,
            "message" => "Search results returned successfully."
        ));

    }

}else {

    http_response_code(405); // method not allowed

    echo json_encode(array(
        "status" => 405,
        "message" => "Access denied, only GET method is allowed including query parameters"
    ));
}

