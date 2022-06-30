<?php

include('config/db_connect.php');
$email = $title = $ingredients = '';
$errors = array('email' => '', 'title' => '', 'ingredients' => '');

if (isset($_POST['submit'])) {
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required <br/>';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Needs a valid email';
        }
    }
    if (empty($_POST['title'])) {
        $errors['title'] = 'A title is required <br/>';
    } else {
        $title = $_POST['title'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) {
            $errors['title'] = 'Only letters and spaces are allowed';
        }
    }
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = 'At least one ingredient is required <br/>';
    } else {
        $ingredients = $_POST['ingredients'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
            $errors['ingredients'] = 'The ingredients needs to be comma seperated';
        }
    }
    if (array_filter($errors)) {
    } else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        //Create sql
        $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title','$email','$ingredients')";

        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            echo 'Connection error: ' . mysqli_error($conn);
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php') ?>

<section class="container grey-text">
    <h4 class="center">ADD A PIZZA</h4>
    <form method="post" action="" class="white">
        <label for="email">Your email</label>
        <input type="email" name="email" id="" value="<?= htmlspecialchars($email)  ?>">
        <div class="red-text">
            <?= $errors['email'] ?>
        </div>
        <label for="title">Pizza Title</label>
        <input type="text" name="title" id="" value="<?= htmlspecialchars($title)  ?>">
        <div class="red-text">
            <?= $errors['title'] ?>
        </div>
        <label for="ingredients">Ingredients (comma seperated)</label>
        <input type="text" name="ingredients" id="" value="<?= htmlspecialchars($ingredients)  ?>">
        <div class="red-text">
            <?= $errors['ingredients'] ?>
        </div>
        <div class="center">
            <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('templates/footer.php') ?>

</html>