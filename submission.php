<?php
session_start();
include 'include/config.php';

if (isset($_POST['submit'])) {
    if ($_SESSION['captcha1'] + $_SESSION['captcha2'] == $_POST['vc']) {
        if (empty($_POST['name'])) {
            $nameerr = 'Name Feild Are Required';
        } else {
            $name = validateinput($_POST['name']);
        }
        if (empty($_POST['category'])) {
            $categoryerror = 'Please Select Category';
        } else {
            $category = validateinput($_POST['category']);
        }

        $allowed = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'JPEG', 'JPG', 'PNG', 'GIF', 'BMP'];
        $tmpname = $_FILES['image']['tmp_name'];
        $iname = $_FILES['image']['name'];
        $file_ext = pathinfo($iname, PATHINFO_EXTENSION);

        if (empty($_FILES['image']['name'])) {
            $imageerr = 'Please Select a image';
        } else {
            if (!in_array($file_ext, $allowed)) {
                $imageerr = 'jpg, jpeg, png only';
            }
            if ($_FILES['image']['size'] > 1000000) {
                $imageerr = 'Please select image size below 1 MB';
            }
        }
        if (empty($_POST['description'])) {
            $deserr = 'Please fill the description field';
        } else {
            $description = validateinput($_POST['description']);
        }
        if (empty($_POST['life'])) {
            $lifeerr = 'Select Life Expectancy ';
        } else {
            $life = validateinput($_POST['life']);
        }
        if ($name == true and $category == true and $description == true and $life == true) {
            $query = "insert into animal(name,category,image,description,life_expectancy) values('".$name."','".$category."','".$iname."','".$description."','".$life."')";
            $que = mysqli_query($conn, $query);

            if ($que) {
                move_uploaded_file($tmpname, 'upload/'.$iname);
                header('location:animal.php');
            } else {
                echo 'somethng wrong please try again';
            }
        } else {
        }
    } else {
        $errorcaptcha = 'Incurrect Captcha Code';
    }
}

$captcha1 = rand(10, 99);
$_SESSION['captcha1'] = $captcha1;

$captcha2 = rand(1, 10);
$_SESSION['captcha2'] = $captcha2;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <h1 align="center">Insert Animal Details <a href="index.php">View</a></h1>

<form action="" method="post" enctype="multipart/form-data">
    <table align="center" id="table" border=0 height="100%" width="50%">
        <tr>
            <td>Name </td>
            <td>
                <input type="text" id="name" name="name"/>
                <?php if (isset($nameerr)) { ?>
                        <m id='err'><?php echo $nameerr; ?></m>
                     <?php $nameerr = ''; } ?>
        </td>
        <td>  </td>
        </tr>
        <tr>
            <td>Category</td>
            <td>herbivores <input type="radio" name="category" value="herbivores"/>
                   omnivores <input type="radio" name="category" value="omnivores"/>
                   carnivores <input type="radio" name="category" value="carnivores"/>
                   <?php if (isset($categoryerror)) { ?>
                        <m id='err'><?php echo $categoryerror; ?></m>
                     <?php $categoryerror = ''; } ?>
            </td>
        </tr>
        <tr>
            <td>Image</td>
            <td>
                <input type="file" id="file" name='image'/>
                <?php if (isset($imageerr)) { ?>
                        <m id='err'><?php echo $imageerr; ?></m>
                     <?php $imageerr = ''; } ?>
            </td>
        </tr>
        <tr>
            <td>Description</td>
            <td>
                <textarea rows=3 id="des" cols=70 name="description"></textarea>
                <?php if (isset($deserr)) { ?>
                        <m id='err'><?php echo $deserr; ?></m>
                     <?php $deserr = ''; } ?>
            </td>
        </tr>
        <tr>
            <td>Life Span</td>
            <td>
                <select name="life" id="life">
                    <option value="">Select Life Expectancy</option>
                    <option value="0-1 year">0-1 year</option>
                    <option value="1-5 year">1-5 year</option>
                    <option value="5-10 year">5-10 year</option>
                    <option value="10+ year">10+ year</option>
                </select>
                <?php if (isset($lifeerr)) { ?>
                        <m id='err'><?php echo $lifeerr; ?></m>
                     <?php $lifeerr = ''; } ?>
            </td>
        </tr>
        <tr>
            <td>Captcha :</td>
            <td>
                <span id='cap'><?php echo $captcha1.' '.' + '.$captcha2; ?></span>&nbsp;
                <input type="text" autocomplete="off" id="vc" name="vc"/>
                <?php if (isset($errorcaptcha)) { ?>
                        <m id='err'><?php echo $errorcaptcha; ?></m>
                     <?php $errorcaptcha = ''; } ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit" id="submit" name="submit">Save</button></td>
        </tr>
    </table>
</form>
</body>
</html>