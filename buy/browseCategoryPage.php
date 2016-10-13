<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");

    // create connection and connect to the Twizla database
    $conn = dbConnect();

    if(isset($_GET['CategoryName']))
    {
        $nameOrginal = getOriginalName($_GET['CategoryName']);
        //get the list of subCategory belong to this category
        $loadHomeSQL = "SELECT * FROM subcategory WHERE CategoryID = (SELECT CategoryID FROM category WHERE CategoryName = '$nameOrginal') ORDER BY subCategoryName ASC";
//        echo $loadHomeSQL;
        $result = mysql_query($loadHomeSQL) or die(mysql_error());;

        while($row = mysql_fetch_array($result))
        {
             $subCategoryList[] = $row;
        }

        $searchSQL = "SELECT * FROM item, picturelink Where item.ItemID = picturelink.ItemID";

        $searchSQL .= " AND (ItemCategoryID IN (SELECT subCategoryID FROM category, subcategory WHERE subcategory.CategoryID = category.CategoryID AND CategoryName = '$nameOrginal')
                                    OR ItemCategoryID IN (SELECT subSubCategoryID FROM category, subcategory,subsubcategory WHERE subcategory.CategoryID = category.CategoryID AND subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                    CategoryName = '$nameOrginal' )
                                    OR ItemCategoryID IN (SELECT subSubSubCategoryID FROM category, subcategory,subsubcategory, subsubsubcategory  WHERE subcategory.CategoryID = category.CategoryID AND
                                                                                                                                                    subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                                    subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND
                                                                                                                                                    CategoryName = '$nameOrginal'))";
        $searchSQL .= " AND item.timeFinish > '".date('Y-m-d H:i:s')."' AND item.Quantity > 0";

        $result = mysql_query($searchSQL) or die(mysql_error());;

        while($row = mysql_fetch_array($result))
        {
             $itemList[] = $row;
        }

        mysql_close();

        //set the height of the page based on the number of sub category available
        //currently the height of a li object is 23px
        $subListHeight = count($subCategoryList) * 23;

    }


?>

<!--
    Document   : browseCategoryPage.php
    Created on : Dec 22, 2009, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 4/2/2010
-->


<!Include php files for login, sign up function>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <script type="text/javascript" src="<?php echo $PROJECT_PATH;?>javascripts/main.js"></script>

        <?php
            include("../stylesheet.inc.php");
        ?>

        <link rel="stylesheet" type="text/css" href="http://www.twizla.com.au/css/browse.css" />
    </head>
    <body>
        <?php
            include("../headSection.inc.php");
        ?>

            <div id="middleSection">

            <?php
                if(!isset($_GET['CategoryName']))
                {
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.$PROJECT_PATH.'index.php');

                }
                else
                {
            ?>
                <input type="hidden" id="categoryName" value="<?php echo $nameOrginal;?>"/>
                <input type="hidden" id="subCategoryName" value=""/>
                <input type="hidden" id="subSubCategoryName" value=""/>
                <input type="hidden" id="subCategoryID" value=""/>
                <input type="hidden" id="subSubCategoryID" value=""/>
                <div id="bigHeading" style="margin-left: 10px;"><?php echo $nameOrginal;?></div>
                    <br>
                    <div id="leftPanel" style="width: 260px; float: left; border: 1px solid #c4c4c4; height: 90%; padding: 5px; margin-left: 10px;">
                        <div class="colorLabel" style="margin-left: 10px;">Sub-Category</div>
            <?php

                    echo "<ul id='subSubList' class='categorySideBar' name='list' style='top: 0px;left: 5px; border-left:1px solid; border-color:#c4c4c4;'>";
//                    for($x = 0; $x  < 27; $x++)
//                    {
//                        $subCategoryList[] = $subCategoryList[0];
//                    }
                    foreach($subCategoryList as $subCategory)
                    {
                        ?>
                    <li onmouseover="mOver(this)" onmouseout="mOut(this)" onclick="displayNextList('subSub',<?php echo $subCategory['subCategoryID'];?>, this)"><?php echo $subCategory['subCategoryName'];?></li>
                        <?php
                    }
                    echo "</ul>";
                    
                    echo "<div id='subSubDiv' ></div>";

                    echo "<div id='subSubSubDiv'></div>";

                }
            ?>
                    </div>
                    <!--[if gte IE 6]>
                        <script type="text/javascript">
                            function mOver(obj)
                            {
                                obj.style.backgroundColor = '#7cc5ff';
                            }
                            function mOut(obj)
                            {
                                obj.style.backgroundColor = 'white';
                            }
                        </script>

                    <![endif]-->

                    <div id="rightPanel" style="float: left;border: 1px solid #c4c4c4; padding: 5px; margin-left: 50px; width: 783px; height: 90%; ">
                        <?php
                        include_once '../displayItemList.inc.php';
                        $pageLink = $PROJECT_PATH."category/".$_GET['CategoryName'];
                        displayItemList($itemList,24,"", "latestList","buyItemContainer",true, $pageLink, false);
                        ?>
                    </div>
            </div>


        <?php
            include("../footerSection.inc.php");



            if($subListHeight > 370)
            {
                $addedHeight = $subListHeight - 370;

            ?>
                <script type="text/javascript">
                    window.document.body.style.height = 1178 + <?php echo $addedHeight;?>  + "px";
                    var middleSession = document.getElementById("middleSection");
        //                var borderBox = document.getElementById("mediumBorderBox");
                    middleSession.style.height = 720 + <?php echo $addedHeight;?>  + "px";

                    //case IE, set grassfooter position
                    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) //test for MSIE x.x;
                    {
                        var grassFooter = document.getElementById("grassFooter");
                        grassFooter.style.top = grassFooter.offsetTop + 45 + <?php echo $addedHeight;?> + "px";
                        var footer = document.getElementById("footer");
                        footer.style.top = 1150 + <?php echo $addedHeight;?> + "px";
                    }

                </script>

           <?php
            }

            if(isset($_GET['subName']))
            {

                $searchSQL = "SELECT * FROM subcategory WHERE CategoryID = (SELECT CategoryID FROM category WHERE CategoryName = '$nameOrginal') AND subCategoryName = '".getOriginalName($_GET['subName'])."'";
        //        echo $loadHomeSQL;
                $result = mysql_query($searchSQL) or die(mysql_error());;

                $row = mysql_fetch_array($result);
                $subID = $row['subCategoryID'];

                ?>

                <script>
                    document.getElementById("subCategoryName").value="<?php echo getOriginalName($_GET['subName'])?>";
                    displayNextList('subSub',<?php echo $subID;?>, this);
                </script>
                <?php

                if(isset($_GET['subSubName']))
                {
                    $searchSQL = "SELECT * FROM subsubcategory WHERE subCategoryID IN (SELECT subCategoryID FROM subcategory WHERE subCategoryName = '".getOriginalName($_GET['subName'])."') AND subSubCategoryName = '".getOriginalName($_GET['subSubName'])."'";
            //        echo $loadHomeSQL;
                    $result = mysql_query($searchSQL) or die(mysql_error());;

                    $row = mysql_fetch_array($result);
                    $subSubID = $row['subSubCategoryID'];

                    ?>
                    <script>
                        document.getElementById("subSubCategoryName").value="<?php echo getOriginalName($_GET['subSubName'])?>";
                        displayNextList('subSubSub',<?php echo $_GET['subSubID'];?>, this);
                    </script>
                    <?php
                }
            }


            ?>



    </body>
</html>
