<?php
    include("../mySQL_connection.inc.php");

    
    if(isset($_GET['subSubCategory']))
    {
        
        $conn = dbConnect();
//        $category = $_GET['category'];
        $subSubCategory = $_GET['subSubCategory'];
        $subID = $_GET['subID'];
        // create connection and connect to the Twizla database
        

        // get the list of sub category belong to this category from database
        $sql = "SELECT * FROM subsubsubcategory WHERE subSubCategoryID = $subID
                                                                ORDER BY subSubSubCategoryID";

        $result = mysql_query($sql) or die(mysql_error());

        if(mysql_num_rows($result))
        {
            while($row = mysql_fetch_array($result))
            {
                $subSubSubCategoryList[] = $row;
            }
?>
            
            <!set the subCategoryID ready to be sent to the server later when submit form>
            <input type="hidden" id="subSubCategoryID" name="subSubCategoryID" value=""/>
            <div class="selectedLink"> <a href="javascript:returnSubSubCategoryList();" ><?php echo $subSubCategory;?></a> &nbsp&nbsp>>&nbsp </div>

            <select id="subSubSubCategory" name="subSubSubCategory" style="width:212px;" onchange="setItemCategory(this, 'subSubSub')">
                <option style="font-weight: bold; color:black;" disabled="disabled" selected="selected">Please choose a sub-category</option>
                <?php
                    foreach($subSubSubCategoryList as $subSubSubCategory)
                    {
                        echo "<option value='".$subSubSubCategory['subSubSubCategoryID']."'>".$subSubSubCategory['subSubSubCategoryName']."</option>";

                    }
                ?>
            </select>
            <div id="subSubSubCategorySelection"></div>
<?php
        }

        mysql_close($conn);
    }
    else if(isset($_GET['subCategory']))
    {
        $conn = dbConnect();
//        $category = $_GET['category'];
        $subCategory = $_GET['subCategory'];
        $subID = $_GET['subID'];
        // create connection and connect to the Twizla database

        // get the list of sub category belong to this category from database
        $sql = "SELECT * FROM subsubcategory WHERE subCategoryID = $subID
                                                                ORDER BY subSubCategoryID";

        $result = mysql_query($sql) or die(mysql_error());

        if(mysql_num_rows($result))
        {
            while($row = mysql_fetch_array($result))
            {
                $subSubCategoryList[] = $row;
            }
?>
            <!set the subCategoryID ready to be sent to the server later when submit form>
            <input type="hidden" id="subCategoryID" name="subCategoryID" value=""/>
            <div class="selectedLink"> <a href="javascript:returnSubCategoryList();" ><?php echo $subCategory;?></a> &nbsp&nbsp>>&nbsp </div>
            <br>
            <select id="subSubCategory" name="subSubCategory" style="width:212px;" onchange="getSubSubSubCategory(this)">
                <option style="font-weight: bold; color:black;" disabled="disabled" selected="selected">Please choose a sub-category</option>
                <?php
                    foreach($subSubCategoryList as $subSubCategory)
                    {
                        echo "<option value='".$subSubCategory['subSubCategoryID']."'>".$subSubCategory['subSubCategoryName']."</option>";

                    }
                ?>
            </select>
            <div id="subSubCategorySelection" style="float:left;"></div>
<?php
        }

        mysql_close($conn);
    }
    else if(isset($_GET['category']))
    {
        $conn = dbConnect();
        $category = $_GET['category'];
        // create connection and connect to the Twizla database


        // get the list of sub category belong to this category from database
        $sql = "SELECT * FROM subcategory WHERE CategoryID = (SELECT CategoryID FROM category WHERE CategoryName = '$category') ORDER BY subCategoryID";

        $result = mysql_query($sql) or die(mysql_error());

        while($row = mysql_fetch_array($result))
        {
            $subCategoryList[] = $row;
        }
?>
       <div class="selectedLink"> <a href="javascript:returnCategoryList();" ><?php echo $category;?></a> &nbsp&nbsp>>&nbsp </div>
        <select id="subCategory" name="subCategory" style="width:212px;" onchange="getSubSubCategory(this)" >
                <option style="font-weight: bold; color:black;" disabled="disabled" selected="selected">Please choose a sub-category</option>
            <?php
                foreach($subCategoryList as $subCategory)
                {
                    ?>
                    <option value="<?php echo $subCategory['subCategoryID'];?>" ><?php echo $subCategory['subCategoryName'];?></option>
                    <?php
                }
            ?>
        </select>
        <div id="subCategorySelection" style="float:left;"></div>

<?php
        mysql_close($conn);
    }
?>
