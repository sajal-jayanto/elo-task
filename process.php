<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "programmming_task";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $result = array();
    $action = '';
    $id = '';
    $cash = '';
    $count = '';
    

    if(isset($_GET['action'])){
        $action = $_GET['action'];

    }

    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }

    if(isset($_GET['cash'])){
        $cash = $_GET['cash'];
    }

    if(isset($_GET['count'])){
        $count = $_GET['count'];
    }

    if($action == 'change')
    {
        if(isset($_GET['cash'])){
            $conn->query("UPDATE cash SET cash=$cash WHERE id=1");
        }
        if(isset($_GET['count'])){
            $conn->query("UPDATE ingredients SET stock=$count WHERE id=$id");
        }
    }

    if($action == 'list')
    {
        $sql = $conn->query("SELECT id , item , price FROM sells");
        $temps = array();
        $cnt = 0;
        while($row = $sql->fetch_assoc()){
            $id = $row['id'];
            $sql1 = $conn->query("SELECT ingredients.ingredient , recipe.ingredients_cnt FROM recipe JOIN ingredients ON ingredients.id=recipe.ingredients_id WHERE recipe.sells_id=$id");
            $items = array();
            while($newrow = $sql1->fetch_assoc()){
                array_push($items, $newrow);
            }
            array_push($temps, $row);
            $temps[$cnt]['recipe'] = $items;
            $cnt = $cnt + 1;
        }
        $result['temps'] = $temps;
        
    }


    if($action == 'cash'){
        $sql = $conn->query("select * from cash");
        $temps = array();
        while($row = $sql->fetch_assoc()){
            array_push($temps , $row);
        }
        $result['temps'] = $temps[0];
    }

    if($action == 'read'){
        $sql = $conn->query("select * from ingredients");
        $temps = array();
        while($row = $sql->fetch_assoc()){
            array_push($temps , $row);
        }
        $result['temps'] = $temps;
    }


    echo json_encode($result);
?>
