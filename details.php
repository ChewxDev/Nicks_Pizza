<?php

include('config/db_connect.php');

if (isset($_POST['delete'])) {

    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM pizzas WHERE id = '$id_to_delete'";

    if (mysqli_query($conn, $sql)) {
        header('Location:index.php');
    } else {
        echo 'Connection error: ' . mysqli_error($conn);
    }
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    //Make sql
    $sql = "SELECT * FROM pizzas WHERE id = '$id'";

    //Get the query result
    $result = mysqli_query($conn, $sql);

    //Fetch as assoc array
    $pizza = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
}


?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php') ?>
<div class="container center">
    <?php if ($pizza) : ?>
    <h4>
        <?= htmlspecialchars($pizza['title']) ?>
    </h4>
    <p>
        Created by: <?= htmlspecialchars($pizza['email']) ?>
    </p>
    <p><?= date($pizza['created_at']) ?></p>
    <h5>Ingredients:</h5>
    <p><?= htmlspecialchars($pizza['ingredients']) ?></p>

    <!-- DELETE FORM-->
    <form action="details.php" method="POST">
        <input type="hidden" name="id_to_delete" value="<?= $pizza['id'] ?>">
        <input type="submit" value="Delete" name="delete" class="btn brand z-depth-0">
    </form>
    <?php else : ?>
    <h5>No such pizza exists!</h5>
    <?php endif ?>
</div>
<?php include('templates/footer.php') ?>

</html>