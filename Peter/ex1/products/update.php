<?php
session_start();

if (isset($_SESSION[ 'user']) != "") {
  header("Location: ../home.php");
  exit ;
}

if (!isset($_SESSION['adm']) && !isset ($_SESSION['user'])) {
  header("Location: ../index.php");
  exit ;
}

require_once '../components/db_connect.php';

if ($_GET['id']) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM dishes WHERE dishID= {$id}";
    $result = mysqli_query($connect, $sql);
    if (mysqli_num_rows($result) == 1) {
        $data = mysqli_fetch_assoc($result);
        $name = $data['name'];
        $price = $data['price'];
        $picture = $data['image'];
        $supplier = $data['fk_supplierId'];

        $sql = "SELECT * FROM suppliers";
        $result = mysqli_query($connect, $sql); //can be overwritten because old result (and sql) were used before and arent called again past this point
        
        $select = "";
        //from serri
        while($row = mysqli_fetch_assoc($result)){     //serri live coding
            if($row["supplierId"] == $supplier) {
                $select .=
                "<option selected value='{$row['supplierId']}'>{$row['sup_name']}</option>";
            }else{
                $select .=
                "<option value='{$row['supplierId']}'>{$row['sup_name']}</option>";
            }
           
        }

        // from prework
        /* if (mysqli_num_rows($result)>0){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                if($row['supplierId']== $supplier){
                    $select .= "<option selected value='{$row['supplierId']}'>{$row['sup_name']}</option>";
                } else {
                    $select .= "<option value='{$row['supplierId']}'>{$row['sup_name']}</option>" ;
                }
            }
        } else {
            $select = "<li>There are no suppliers registered</li>"; 
        } */
    } else {
        header("location: error.php");
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Product</title>
        <?php require_once '../components/boot.php'?>
        <style type= "text/css">
            fieldset {
                margin: auto;
                margin-top: 100px;
                width: 60% ;
            }  
            .img-thumbnail{
                width: 70px !important;
                height: 70px !important;
            }     
        </style>
    </head>
    <body>
        <fieldset>
            <legend class='h2'>Update request <img class='img-thumbnail rounded-circle' src='../pictures/<?php echo $picture ?>' alt="<?php echo $name ?>"></legend>
            <form action="actions/a_update.php"  method="post" enctype="multipart/form-data">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td><input class="form-control" type="text"  name="name" placeholder ="Product Name" value="<?php echo $name ?>"  /></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td><input class="form-control" type= "number" name="price" step="any"  placeholder="Price" value ="<?php echo $price ?>" /></td>
                    </tr>
                    <tr>
                        <th>Picture</th>
                        <td><input class="form-control" type="file" name= "picture" /></td>
                    </tr>
                    <tr>
                        <th>Supplier</th>
                        <td>
                            <select name="supplier">
                                <!-- <option value="none">Undefined</option> -->
                                <?= $select; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <input type= "hidden" name= "id" value= "<?php echo $data['dishID'] ?>" />
                        <input type= "hidden" name= "picture" value= "<?php echo $data['image'] ?>" />
                        <td><button class="btn btn-success" type= "submit">Save Changes</button></td>
                        <td><a href= "index.php"><button class="btn btn-warning" type="button">Back</button></a></td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </body>
</html>