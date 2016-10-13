<?php

    include("../mySQL_connection.inc.php");

    if($_GET['type'] == 'subSub')
    {

        $subID = $_GET['subID'];
        // create connection and connect to the Twizla database
        $conn = dbConnect();

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
            echo "<div class='colorLabel' style='margin-left: 10px;'>Sub-Category</div>";
            echo "<ul id ='subSubSubList' class='categorySideBar' style='top: 0px;left: 5px; border-left:1px solid; border-color:#c4c4c4;'>";
    //                    for($x = 0; $x  < 27; $x++)
    //                    {
    //                        $subCategoryList[] = $subCategoryList[0];
    //                    }
            foreach($subSubCategoryList as $subSubCategory)
            {

                ?>
                <li onmouseover="mOver(this)" onmouseout="mOut(this)"  onclick="displayNextList('subSubSub',<?php echo $subSubCategory['subSubCategoryID'];?>, this)"><?php echo $subSubCategory['subSubCategoryName'];?></li>
                <?php
            }
            echo "</ul>";
        }
    }
    else if($_GET['type'] == 'subSubSub')
    {
        $subID = $_GET['subID'];
        // create connection and connect to the Twizla database
        $conn = dbConnect();

        // get the list of sub category belong to this category from database
        $sql = "SELECT * FROM subsubsubcategory WHERE subSubCategoryID = $subID
                                                        ORDER BY subSubSubCategoryID";

        $result = mysql_query($sql) or die(mysql_error());

        //display the next sub list if available, else go straight to the search result page
        if(mysql_num_rows($result))
        {

            while($row = mysql_fetch_array($result))
            {
                $subSubSubCategoryList[] = $row;
            }
    //                    for($x = 0; $x  < 27; $x++)
    //                    {
    //                        $subCategoryList[] = $subCategoryList[0];
    //                    }
            //make sure the number of category listed is not overflow out of the page
                echo "<div class='colorLabel' style='margin-left: 10px;'>Sub-Category</div>";
                echo "<ul class='categorySideBar' style='top: 0px;left: 5px; border-left:1px solid; border-color:#c4c4c4;'>";
                foreach($subSubSubCategoryList as $subSubSubCategory)
                {
                    ?>
                    <li onmouseover="mOver(this)" onmouseout="mOut(this)"  onclick="displayNextList('showItem',<?php echo $subSubSubCategory['subSubCategoryID'];?>, this);"><?php echo $subSubSubCategory['subSubSubCategoryName'];?></li>
                    <?php
                }
//            }
            echo "</ul>";
        }
    }
?>
