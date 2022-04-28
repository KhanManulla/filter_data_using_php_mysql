<?php
session_start();
require_once 'include/config.php';
if (empty($_SESSION['uip'])) {
    $_SESSION['uip'] = $_SERVER['REMOTE_ADDR'];

    $visitors = file_get_contents('visitors.txt');
    $visitors = (int) $visitors + 1;
    file_put_contents('visitors.txt', $visitors);
} else {
}

if (isset($_POST['btnclear'])) {
    $_POST['category'] = '';
    $_POST['life'] = '';
    $_POST['filterby'] = '';
    $_POST['orderby'] = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/animal.css">
</head>
<body>
<b><p align="left" style="margin:5px;">
    Site Visitor <?php $content = file_get_contents('visitors.txt');
    echo $content; ?>
    </p> </b>
   
    
    <h1 align="center">Animal Species <a href="submission.php"><m>Add Animal Details</m></a></h1>
    <div class="filter">
       
         <div class="filter">
        <form action="" method="POST">
          <select name="category" onchange="myFunction()" id="cat">
          <option value="">Select Category</option>
          <option value="all" <?php if (isset($_POST['category']) && $_POST['category'] == 'all') {
        echo ' selected="selected"';
    }?>>All</option> 
            <option value="herbivores" <?php if (isset($_POST['category']) && $_POST['category'] == 'herbivores') {
        echo ' selected="selected"';
    }?> >herbivores</option>
                    <option value="omnivores" <?php if (isset($_POST['category']) && $_POST['category'] == 'omnivores') {
        echo ' selected="selected"';
    }?>>omnivores</option>
                    <option value="carnivores" <?php if (isset($_POST['category']) && $_POST['category'] == 'carnivores') {
        echo ' selected="selected"';
    }?>>carnivores</option>    
        </select>
       
        
        <select name="life" id="life">

        <option value="">Select Life Expectancy</option>
                    <option value="0-1 year"  <?php if (isset($_POST['life']) && $_POST['life'] == '0-1 year') {
        echo ' selected="selected"';
    }?>>0-1 year</option>
                    <option value="1-5 year"  <?php if (isset($_POST['life']) && $_POST['life'] == '1-5 year') {
        echo ' selected="selected"';
    }?>>1-5 year</option>
                    <option value="5-10 year"  <?php if (isset($_POST['life']) && $_POST['life'] == '5-10 year') {
        echo ' selected="selected"';
    }?>>5-10 year</option>
                    <option value="10+ year"  <?php if (isset($_POST['life']) && $_POST['life'] == '10+ year') {
        echo ' selected="selected"';
    }?>>10+ year</option>
        </select>
        

  

        <filterlabel>Filter By:
        
        <input type="radio"  <?php if (isset($_POST['filterby']) && $_POST['filterby'] == 'name') {
        echo ' checked="checked"';
    }?> name='filterby' id='check' value="name"> Name
        <input type="radio" <?php if (isset($_POST['filterby']) && $_POST['filterby'] == 'subdate') {
        echo ' checked="checked"';
    }?>  name="filterby" id='check' value="subdate"> Date
        
        &nbsp;||&nbsp;
        
        Order By:
        
        <input type="radio" <?php if (isset($_POST['orderby']) && $_POST['orderby'] == 'asc') {
        echo ' checked="checked"';
    }?> name='orderby' id='check' value="asc"> ASC
        <input type="radio" <?php if (isset($_POST['orderby']) && $_POST['orderby'] == 'desc') {
        echo ' checked="checked"';
    }?> name="orderby" id='check' value="desc"> DESC
        
        </filterlabel>

        <button id='btncat' name='btncat' >Filter</button>
        <button  id='btncat' name='btnclear' >clear</button>
        </form>
        
       
    </div>

    <!-- card for animal-->
    <div class="main-container">
        <?php
        if (isset($_POST['btncat'])) {
            if (empty($_POST['category']) and empty($_POST['life'])) {
                echo "<h1 align='center'> Please Select atleast one option</h1>";
            }
            if (!empty($_POST['category']) and !empty($_POST['life'])) {
                if (empty($_POST['filterby'])) {
                    $filterby = 'name';
                } else {
                    $filterby = $_POST['filterby'];
                }
                if (empty($_POST['orderby'])) {
                    $orderby = 'asc';
                } else {
                    $orderby = $_POST['orderby'];
                }

                $sql = "select *  from animal where category='".$_POST['category']."' and life_expectancy='".$_POST['life']."' order by $filterby $orderby";
                $run = mysqli_query($conn, $sql);
                if (mysqli_num_rows($run) > 0) {
                    while ($r = mysqli_fetch_assoc($run)) {
                        ?>
                     <div class="card">
                                <div class='image'>
                                    <img src="upload/<?php echo $r['image']; ?>" alt='<?php echo $r['name']; ?>'/>
                                </div>
                                <div class="name">
                                <h3>Animal Name  : <?php echo $r['name']; ?></h3>
                                <h4>Category     : <?php echo $r['category']; ?></h4>
                                <h4>Life         : <?php echo $r['life_expectancy']; ?></h4>
                                <h4>Post Date    : <?php echo $r['subdate']; ?></h4>
                                </div>
                                <div class="description">
                                    <p>Description :</p>
                                    <p><?php echo $r['description']; ?></p>
                                </div>
                            </div>
                    <?php
                    }
                } else {
                    echo "<h1 align='center'> No result Found Try Another combination</h1>";
                }
            }
            if (empty($_POST['life']) and !empty($_POST['category']) and !($_POST['category'] == 'all')) {
                if (empty($_POST['filterby'])) {
                    $filterby = 'name';
                } else {
                    $filterby = $_POST['filterby'];
                }
                if (empty($_POST['orderby'])) {
                    $orderby = 'asc';
                } else {
                    $orderby = $_POST['orderby'];
                }
                $sql = "select *  from animal where category='".$_POST['category']."'  order by $filterby $orderby";
                $run = mysqli_query($conn, $sql);
                if (mysqli_num_rows($run) > 0) {
                    while ($r = mysqli_fetch_assoc($run)) {
                        ?>
                     <div class="card">
                                <div class='image'>
                                    <img src="upload/<?php echo $r['image']; ?>" alt='<?php echo $r['name']; ?>'/>
                                </div>
                                <div class="name">
                                <h3>Animal Name  : <?php echo $r['name']; ?></h3>
                                <h4>Category     : <?php echo $r['category']; ?></h4>
                                <h4>Life         : <?php echo $r['life_expectancy']; ?></h4>
                                <h4>Post Date    : <?php echo $r['subdate']; ?></h4>
                                </div>
                                <div class="description">
                                    <p>Description :</p>
                                    <p><?php echo $r['description']; ?></p>
                                </div>
                            </div>
                    <?php
                    }
                } else {
                    echo "<h1 align='center'> No result Found Try Another combination</h1>";
                }
            }

            //fetch all data with filter order by asc and desc
            if (empty($_POST['life']) and !empty($_POST['category']) and $_POST['category'] == 'all') {
                if (empty($_POST['filterby'])) {
                    $filterby = 'name';
                } else {
                    $filterby = $_POST['filterby'];
                }
                if (empty($_POST['orderby'])) {
                    $orderby = 'asc';
                } else {
                    $orderby = $_POST['orderby'];
                }

                $sql = "select *  from animal order by $filterby $orderby";
                $run = mysqli_query($conn, $sql);
                if (mysqli_num_rows($run) > 0) {
                    while ($r = mysqli_fetch_assoc($run)) {
                        ?>
                     <div class="card">
                                <div class='image'>
                                    <img src="upload/<?php echo $r['image']; ?>" alt='<?php echo $r['name']; ?>'/>
                                </div>
                                <div class="name">
                                <h3>Animal Name  : <?php echo $r['name']; ?></h3>
                                <h4>Category     : <?php echo $r['category']; ?></h4>
                                <h4>Life         : <?php echo $r['life_expectancy']; ?></h4>
                                <h4>Post Date    : <?php echo $r['subdate']; ?></h4>
                                </div>
                                <div class="description">
                                    <p>Description :</p>
                                    <p><?php echo $r['description']; ?></p>
                                </div>
                            </div>
                    <?php
                    }
                } else {
                    echo "<h1 align='center'> No result Found Try Another combination</h1>";
                }
            }
            ///fetch all data end
            if (!empty($_POST['life']) and empty($_POST['category'])) {
                if (empty($_POST['filterby'])) {
                    $filterby = 'name';
                } else {
                    $filterby = $_POST['filterby'];
                }
                if (empty($_POST['orderby'])) {
                    $orderby = 'asc';
                } else {
                    $orderby = $_POST['orderby'];
                }
                $sql = "select *  from animal where life_expectancy='".$_POST['life']."' order by $filterby $orderby";
                $run = mysqli_query($conn, $sql);
                if (mysqli_num_rows($run) > 0) {
                    while ($r = mysqli_fetch_assoc($run)) {
                        ?>
                     <div class="card">
                                <div class='image'>
                                    <img src="upload/<?php echo $r['image']; ?>" alt='<?php echo $r['name']; ?>'/>
                                </div>
                                <div class="name">
                                <h3>Animal Name  : <?php echo $r['name']; ?></h3>
                                <h4>Category     : <?php echo $r['category']; ?></h4>
                                <h4>Life         : <?php echo $r['life_expectancy']; ?></h4>
                                <h4>Post Date    : <?php echo $r['subdate']; ?></h4>
                                </div>
                                <div class="description">
                                    <p>Description :</p>
                                    <p><?php echo $r['description']; ?></p>
                                </div>
                            </div>
                    <?php
                    }
                } else {
                    echo "<h1 align='center'> No result Found Try Another combination</h1>";
                }
            }
        } else {
            ?>
        <?php
        $sql = 'select * from animal';
            $query = mysqli_query($conn, $sql);
            if (mysqli_num_rows($query) > 0) {
                while ($r = mysqli_fetch_assoc($query)) {
                    ?>
        <div class="card">
            <div class='image'>
                <img src="upload/<?php echo $r['image']; ?>" alt='<?php echo $r['name']; ?>'/>
            </div>
            <div class="name">
            <h3>Animal Name  : <?php echo $r['name']; ?></h3>
            <h4>Category     : <?php echo $r['category']; ?></h4>
            <h4>Life         : <?php echo $r['life_expectancy']; ?></h4>
            <h4>Post Date    : <?php echo $r['subdate']; ?></h4>
            </div>
            <div class="description">
                <p>Description :</p>
                <p><?php echo $r['description']; ?></p>
            </div>
        </div>
        <?php
                }
            } else {
                echo "<h1 align='center'> Record are empty please <a href='submission.php'>Add animal details</a></h1>";
            } ?>
        <?php
        } ?>
        
    </div>
</body>
<script>
                function myFunction() {
                    var x = document.getElementById("cat").value;
                    if(x=='all'){
                        document.getElementById("life").setAttribute("disabled", "disabled");
                    }
                    else{
                        document.getElementById("life").removeAttribute("disabled");
                    }
                    }
        </script>
</html>
