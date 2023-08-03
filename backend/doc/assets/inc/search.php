<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <?php 
     include_once('config.php');
                                        if (isset($_POST['input'])) {
                                            $input = $_POST['input'];

                                            $query = "SELECT * FROM  linearizationminioutput_specialty_adaptation_dermatology_en WHERE Code LIKE '{$input}%' OR Title LIKE '{$input}%'";
                                            $stmt = $mysqli -> prepare($query);
                                            $stmt -> execute();
                                            $res = $stmt -> get_result();

                                            print_r($res);
                                            if (($res->num_rows) > 0) {

                                                while ($ds = $res -> fetch_object()) {
                                            
                                                    ?>

                                                        <option value="<?php echo $ds->Title; ?>"><?php echo $ds->Title; ?></option>
                                            
                                            <?php     }

                                            } 
                                            else {

                                                echo '<option class="text-danger text-center">Data not found</option>';
                                            }

                                        }

                                        ?>
    
</body>
</html>