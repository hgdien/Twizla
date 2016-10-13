<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");
?>

<!--
    Document   : searchProduct.php
    Created on : Dec 22, 2009, 12:36:45 PM
    Author     : Peter
    Description:
        Function to search for particular product

    Updated: 12/1/2009
-->


<?php

    // process the script only if the form has been submitted
    if(isset($_GET['searchSubmit']))
    {
        //create connection and connect to the Twizla database
        $conn = dbConnect();

        // prepare the query for searching
        //if there is no specific searchString then display all item in that category
        $searchSQL = "SELECT * FROM item, picturelink Where item.ItemID = picturelink.ItemID";

        //check if is directed from the confirmPurchase page to list item sell by a particular seller
        if(isset($_GET['SellerID']))
        {
            $searchSQL .= " And SellerID = ".$_GET['SellerID'];
        }
        else if(isset($_GET['FBFriendSelling']))
        {

            $friends = $facebook->api('/'.$id.'/friends');

            foreach($friends as $friend)
            {
                $sql ="SELECT * FROM user WHERE UserName = '".$friend[0]['name']."' AND password = 'FB_".$friend[0]['id']."'";

                $result = mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_array($result);
                if(mysql_num_rows($result))
                {
                    $FBFriendList[] = $row['UserID'];
                }
            }

            if(count($FBFriendList) > 0)
            {
                $searchSQL .= " AND SellerID IN (";

                foreach($FBFriendList as $friend)
                {
                    $searchSQL .= $friend.", ";
                }

                $searchSQL .= ")";
            }
            else
            {
                //no FB friend listing
                //set wrong sql param so the search return 0
                $searchSQL .= " AND 2=3";
            }

        }
        else if(isset($_GET['CategoryType'])) //check if is currently directed from the browse category page
        {
//             $searchSQL .= " And item.CategoryType = '".$_GET['CategoryType']."' AND item.ItemCategoryID = ".$_GET['subID'];

            if($_GET['CategoryType'] == 'sub')
            {
                $searchSQL .= " And ((item.CategoryType = '".$_GET['CategoryType']."' AND item.ItemCategoryID = ".$_GET['subID'].")";

                $searchSQL .= " OR (item.CategoryType = 'subSub' AND item.ItemCategoryID IN (SELECT subSubCategoryID FROM subcategory,subsubcategory WHERE subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                                           subcategory.subCategoryID = ".$_GET['subID']."))";

                $searchSQL .= " OR (item.CategoryType = 'subSubSub' AND item.ItemCategoryID IN (SELECT subSubSubCategoryID FROM subsubcategory, subsubsubcategory WHERE subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND
                                                                                                                                                                        subsubcategory.subSubCategoryID IN
                                                                                                                                                                         (SELECT subSubCategoryID FROM subcategory,subsubcategory WHERE subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                                                                                                                subcategory.subCategoryID = ".$_GET['subID']."))))";



            }
            else if($_GET['CategoryType'] == 'subSub')
            {
                $searchSQL .= " And ((item.CategoryType = '".$_GET['CategoryType']."' AND item.ItemCategoryID = ".$_GET['subID'].")";

                $searchSQL .= " OR (item.CategoryType = 'subSubSub' AND item.ItemCategoryID IN (SELECT subSubSubCategoryID FROM subsubcategory, subsubsubcategory WHERE subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND
                                                                                                                                                                        subsubcategory.subSubCategoryID = ".$_GET['subID'].")))";

            }
            else if($_GET['CategoryType'] == 'subSubSub')
            {
                $searchSQL .= " And item.CategoryType = '".$_GET['CategoryType']."' AND item.ItemCategoryID = ".$_GET['subID'];
            }
        }
        else
        {

            $searchStr = $_GET['searchString'];
            $category = $_GET['searchCategory'];

            if (!get_magic_quotes_gpc())
            {
                $searchStr = addslashes($searchStr);
                $category = addslashes($category);

            }

//            echo $searchStr.'<br>';
//            echo $category.'<br>';


            //***important: put ( ) for each condition to prevent the whole SQL go amock ***//
            //The whole SQL should have the format: SELECT * FROM item, picturelink Where Item.ItemID = picturelink.ItemID
            //(AND searchstring condition) (AND category condition) GROUP BY item.ItemID (ORDER BY filter condition).
            //else search based on the search string
            if($searchStr != '')
            {
                //check the number of search words inputted
                //if there is more than one then break the search string and create
                //the sql query to search each search key word.
                if(is_numeric($searchStr))
                {
                    $searchSQL .= " AND item.ItemID = $searchStr";
                }
                else if(strstr($searchStr," "))
                {
                    $searchWords = strtok($searchStr," ");
                    //get rid of "s, es" character that determined plural
                    //to get more accurate search result
                    $searchWords = removePluralSign($searchWords);

                    $searchSQL .= " AND (ItemTitle LIKE '%$searchWords%'";
                    //set the query in case the search string include item category (books, car)

                    $searchSQL .= " OR ItemCategoryID IN (SELECT subCategoryID FROM category, subcategory WHERE subcategory.CategoryID = category.CategoryID AND (CategoryName = '$searchWords' OR subCategoryName  = '$searchWords'))
                                    OR ItemCategoryID IN (SELECT subSubCategoryID FROM category, subcategory,subsubcategory WHERE subcategory.CategoryID = category.CategoryID AND subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                    (CategoryName = '$searchWords' OR subCategoryName  = '$searchWords' OR subSubCategoryName = '$searchWords'))
                                    OR ItemCategoryID IN (SELECT subSubSubCategoryID FROM category, subcategory,subsubcategory, subsubsubcategory  WHERE subcategory.CategoryID = category.CategoryID AND
                                                                                                                                                    subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                                    subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND
                                                                                                                                    (CategoryName = '$searchWords' OR subCategoryName  = '$searchWords' OR subSubCategoryName = '$searchWords' OR subSubSubCategoryName = '$searchWords'))";


//                    ItemCategoryID IN (SELECT ItemCategoryID FROM itemcategory, category, subcategory, subsubcategory, subsubsubcategory WHERE subsubsubcategory.subSubSubCategoryID = itemcategory.subSubSubCategoryID AND
//                                                                                                                                    subsubcategory.subSubCategoryID = itemcategory.subSubCategoryID AND
//                                                                                                                                    subcategory.subCategoryID = itemcategory.subCategoryID AND
//                                                                                                                                    category.CategoryID = itemcategory.CategoryID AND
//                                                                                                                                    (CategoryName = '$searchWords'
//                                                                                                                                    OR subSubCategoryName = '$searchWords'
//                                                                                                                                    OR subCategoryName  = '$searchWords'
//                                                                                                                                    OR subSubSubCategoryName = '$searchWords'))";
                    while(is_string($searchWords))
                    {
                        $searchWords = strtok(" ");
                        if($searchWords)
                        {
                            //get rid of "s, es" character that determined plural
                            //to get more accurate search result
//                            $searchWords = removePluralSign($searchWords);

                            $searchSQL .= " OR ItemTitle LIKE '%$searchWords%'";
                            //set the query in case the search string include item category (books, car)
                            $searchSQL .= " OR ItemCategoryID IN (SELECT subCategoryID FROM category, subcategory WHERE subcategory.CategoryID = category.CategoryID AND (CategoryName = '$searchWords' OR subCategoryName  = '$searchWords'))
                                    OR ItemCategoryID IN (SELECT subSubCategoryID FROM category, subcategory,subsubcategory WHERE subcategory.CategoryID = category.CategoryID AND subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                    (CategoryName = '$searchWords' OR subCategoryName  = '$searchWords' OR subSubCategoryName = '$searchWords'))
                                    OR ItemCategoryID IN (SELECT subSubSubCategoryID FROM category, subcategory,subsubcategory, subsubsubcategory  WHERE subcategory.CategoryID = category.CategoryID AND
                                                                                                                                                    subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                                    subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND
                                                                                                                                    (CategoryName = '$searchWords' OR subCategoryName  = '$searchWords' OR subSubCategoryName = '$searchWords' OR subSubSubCategoryName = '$searchWords'))";
                        }
                    }
                    $searchSQL .= " )";

                }
                else
                {
                    //get rid of "s, es" character that determined plural
                    //to get more accurate search result
//                    $searchStr = removePluralSign($searchStr);

                    $searchSQL .= " AND (ItemTitle LIKE '%$searchStr%'";
                    //set the query in case the search string include item category (books, car)
                    $searchSQL .= " OR ItemCategoryID IN (SELECT subCategoryID FROM category, subcategory WHERE subcategory.CategoryID = category.CategoryID AND (CategoryName = '$searchStr' OR subCategoryName  = '$searchStr'))
                                    OR ItemCategoryID IN (SELECT subSubCategoryID FROM category, subcategory,subsubcategory WHERE subcategory.CategoryID = category.CategoryID AND subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                    (CategoryName = '$searchStr' OR subCategoryName  = '$searchStr' OR subSubCategoryName = '$searchStr'))
                                    OR ItemCategoryID IN (SELECT subSubSubCategoryID FROM category, subcategory,subsubcategory, subsubsubcategory  WHERE subcategory.CategoryID = category.CategoryID AND
                                                                                                                                                    subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                                    subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND
                                                                                                                                    (CategoryName = '$searchStr' OR subCategoryName  = '$searchStr' OR subSubCategoryName = '$searchStr' OR subSubSubCategoryName = '$searchStr'))";
                    $searchSQL .= " )";

                }

            }
    //        if there is no specific category chosen by user then list all items in all categories
    //        else just list item belong to that category

            if($category != 'All Categories')
            {
                $searchSQL .= " AND (ItemCategoryID IN (SELECT subCategoryID FROM category, subcategory WHERE subcategory.CategoryID = category.CategoryID AND CategoryName = '$category')
                                    OR ItemCategoryID IN (SELECT subSubCategoryID FROM category, subcategory,subsubcategory WHERE subcategory.CategoryID = category.CategoryID AND subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                    CategoryName = '$category' )
                                    OR ItemCategoryID IN (SELECT subSubSubCategoryID FROM category, subcategory,subsubcategory, subsubsubcategory  WHERE subcategory.CategoryID = category.CategoryID AND
                                                                                                                                                    subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                                                                    subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND
                                                                                                                                                    CategoryName = '$category'))";
            }
        }


        //set to display only item that still haven't finished and haven't been sold yet
        $searchSQL .= " AND timeFinish > '".date('Y-m-d H:i:s')."' AND item.Quantity > 0";

        //if there is a display filter then set the display condition
        if(isset($_GET['displayFilter']))
        {
            $filter = $_GET['displayFilter'];
            if($filter == "Auction Only")
            {
                $searchSQL .= " AND (item.Price = 0 OR item.Price IS NULL) ";
            }
            else if($filter == "Buy Now Only")
            {
                $searchSQL .= " AND (item.startingBid = 0 OR item.startingBid IS NULL) ";
            }
        }
        
        //set it to display only one picture per item
        $searchSQL .= " GROUP BY item.ItemID";

        //if there is a filter selected then set the SQL SORT clause
        if(isset($_GET['sortFilter']))
        {
            $filter = $_GET['sortFilter'];
            if($filter == "Lowest bid price")
            {
                $searchSQL .= " ORDER BY currentBid ASC";
            }
            else if($filter == "Highest bid price")
            {
                $searchSQL .= " ORDER BY currentBid DESC";
            }
            else if($filter == "Lowest Buy Now price")
            {
                $searchSQL .= " ORDER BY Price ASC";
            }
            else if($filter == "Highest Buy Now price")
            {
                $searchSQL .= " ORDER BY Price DESC";
            }
            else if($filter == "Time: Ending Soonest")
            {
                $searchSQL .= " ORDER BY timeFinish ASC";
            }
            else if($filter == "Time: Latest Listing")
            {
                $searchSQL .= " ORDER BY listedDate DESC";
            }
            else
            {
                $searchSQL .= " ORDER BY ItemTitle ASC";
            }
        }
        else
        {
            $searchSQL .= " ORDER BY ItemTitle ASC";
        }


        $result = mysql_query($searchSQL) or die(mysql_error());;

        while($row = mysql_fetch_array($result))
        {
            //exclude the item listing that have expired ( ended listing duration)
            $timeFinish = strtotime($row['timeFinish']);
            if(($timeFinish - time()) > 0)
            {
                $itemList[] = $row;
            }
        }

        mysql_close($conn);

        $_SESSION["searchList"] =  $itemList;


    }

    function removePluralSign($string)
    {
        //get rid of "s, es" character that determined plural
        //to get more accurate search result
        if(substr($string, strlen($string) - 2) == 'es')
        {
            $newLength = strlen($string) - 2;
            $string = substr($string, 0, $newLength);
        }
        else if(substr($string, strlen($string) - 1) == 's')
        {
            $newLength = strlen($string) - 1;
            $string = substr($string, 0, $newLength);
        }
        return $string;
    }

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <script type="text/javascript" src="<?php echo $PROJECT_PATH;?>javascripts/main.js"></script>

        <?php
            include("../stylesheet.inc.php");
        ?>

    </head>
    <body>
        <?php
            include("../headSection.inc.php");
        ?>

            <div id="middleSection">
                <div id="middleLeftSection">
                    <div id="bigHeading"><b>Your Search Result!</b></div>
                    <div id="bigHeading"><?php echo count($_SESSION['searchList']);?> item(s) founded.</div>

                    
                    <div id="sortBar">
                        <label style="font-weight: bold; color:#213155; ">Display </label>
                        <select id="displaySelect" style="color:#213155; font-size: 14px; width: 120px;" onchange="sortSearchList()">
                            <option value="All">All</option>
                            <option value="Auction Only">Auction Only</option>
                            <option value="Buy Now Only">Buy Now Only</option>
                        </select>
                        &nbsp;&nbsp;
                        <label style="font-weight: bold; color:#213155; ">Sort by </label>
                        <select id="sortSelect" style="color:#213155; font-size: 14px; width: 165px;" onchange="sortSearchList()">
                            <option value="Name">Name</option>
                            <option value="Lowest bid price">Lowest bid price</option>
                            <option value="Highest bid price">Highest bid price</option>
                            <option value="Lowest Buy Now price">Lowest Buy Now price</option>
                            <option value="Highest Buy Now price">Highest Buy Now price</option>
                            <option value="Time: Ending Soonest">Time: Ending Soonest</option>
                            <option value="Time: Latest Listing">Time: Latest Listing</option>
                        </select>

                        <input type='hidden' id='currentSearchStr' value='<?php echo $_GET['searchString'];?>'/>
                        <input type='hidden' id='currentSearchCategory' value='<?php echo $_GET['searchCategory'];?>'/>
                        <input type="hidden" id="currentSellerID" value="<?php echo $_GET['SellerID'];?>"/>
                        <input type="hidden" id="currentCategoryType" value="<?php echo $_GET['CategoryType'];?>"/>
                        <input type="hidden" id="currentSubID" value="<?php echo $_GET['subID'];?>"/>

                       <?php

                            //set a hidden field for category to apply javascript in the case of edit existing item
                            if(isset($_GET['displayFilter']))
                            {
                        ?>
                                <script type="text/javascript">
                                    var displayBar = document.getElementById("displaySelect");
                                    var display = "<?php echo $_GET['displayFilter'];?>";
                                    for( i = 0;i < displayBar.length ; i++)
                                    {
                                        if(displayBar.options[i].value==display)
                                        {
                                            displayBar.selectedIndex = i;
                                        }
                                    }
                                </script>
                        <?php
                            }

                            if(isset($_GET['sortFilter']))
                            {
                        ?>
                                <script type="text/javascript">
                                    var sortBar = document.getElementById("sortSelect");

                                    var sort =  "<?php echo $_GET['sortFilter'];?>";

                                    for( i = 0;i < sortBar.length ; i++)
                                    {
                                        if(sortBar.options[i].value == sort)
                                        {
                                            sortBar.selectedIndex = i;
                                        }
                                    }

                                </script>
                        <?php
                            }
                       ?>
                    </div>
                    <div id='searchResultBox'>
                    <?php
                    // Display the list of item if there is available search results

//                        echo $searchSQL;

                        include_once '../displayItemList.inc.php';
                         //Determine the number of item to display per page for the search result.
//                       //For the moment the number of item displayed per page is 15.
                        if(isset($_GET['SellerID']))
                        {
                            $link = "searchProductPage.php?"."searchSubmit=true&SellerID=".$_GET['SellerID'];
                        }
                        else if(isset($_GET['CategoryType'])) //check if is currently directed from the browse category page
                        {
                            $link = "searchProductPage.php?"."searchSubmit=true&CategoryType=".$_GET['CategoryType']."&subID=".$_GET['subID'];
                        }
                        else
                        {
                            $link = "searchProductPage.php?"."searchSubmit=true&searchString=".$_GET['searchString']."&searchCategory=".$_GET['searchCategory']."&filter=".$_GET['filter'];
                        }
//                        for($x = 0; $x < 160; $x++)
//                        {
//                            $_SESSION['searchList'][] = $_SESSION['searchList'][0];
//                        }
                        displayItemList($_SESSION['searchList'],15,"", 'searchList','searchItemContainer',true, $link, false);


                    ?>
                    </div>

                </div>

                <?php
                    include("../middleRightSection.inc.php");
                ?>
            </div>
        <?php
            include("../footerSection.inc.php");
        ?>
    </body>
</html>
