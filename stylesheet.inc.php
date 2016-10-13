
        <link rel="shortcut icon" href="<?php echo $PROJECT_PATH;?>webImages/favicon.ico" >

        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/main_firefox.css" />

        <!--[if gte IE 6]>
        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/main_ie.css" />
        <![endif]-->


        <script type="text/javascript" src="<?php echo $PROJECT_PATH;?>javascripts/jquery.js"></script>

        <?php 
        if($_SERVER['PHP_SELF'] == "/index.php")
        {
            ?>
        <title>Twizla – Buying And Selling Online Auctions Australia</title>

        <META name="description" content="Visit Twizla for online auctions across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


        <META name="keywords" content="online auctions, online auction, online auctions Australia, online auction sites, buying online, selling online">
        <?php
        }
        else if(isset($_GET['ItemName']))
        {
            $nameOrginal = str_replace("-", " ", $_GET['ItemName']);
            $nameOrginal = str_replace("%2F", "/", $nameOrginal);
            ?>
            <title><?php echo $nameOrginal;?> | Twizla – Buying And Selling Online Auctions Australia</title>

            <META name="description" content="Visit Twizla Online Auction, a place where buying and selling are made fast and easy.
                  You can register in less than 15 seconds and start your first 30 seconds listing now, IT'S FREE. Buyers can find all kind of products with simple and descriptive information,
                  ready to be won. Twizla will let you taste the joy of buying, selling and online auction in a new experience - Quick and Simple.  ">


            <META name="keywords" content="buy, sell, online auction, twizla, auction, bid">

        <?php

        }
        else if(isset($_GET['UserName']))
        {
            $nameOrginal = str_replace("-", " ", $_GET['UserName']);
            $nameOrginal = str_replace("%2F", "/", $nameOrginal);
            ?>
            <title><?php echo $nameOrginal;?> | Twizla – Buying And Selling Online Auctions Australia</title>

            <META name="description" content="Visit Twizla Online Auction, a place where buying and selling are made fast and easy.
                  You can register in less than 15 seconds and start your first 30 seconds listing now, IT'S FREE. Buyers can find all kind of products with simple and descriptive information,
                  ready to be won. Twizla will let you taste the joy of buying, selling and online auction in a new experience - Quick and Simple.  ">


            <META name="keywords" content="buy, sell, online auction, twizla, auction, bid">

        <?php

        }
        else if(isset($_GET['CategoryName']))
        {
            $nameOrginal = str_replace("-", " ", $_GET['CategoryName']);
            $nameOrginal = str_replace("And", "&", $nameOrginal);
            if($nameOrginal == "Antiques")
            {
                ?>
                <title>Buy And Sell Antiques Auction Online</title>

                <META name="description" content="Visit Twizla for antique auctions online across Australia. The fastest and easiest way to buy and sell antiques today. Free to list and no sales fees.">


                <META name="keywords" content="antiques auction, antiques online, buy antiques, sell antiques">

                <?php
            }
            else if($nameOrginal == "Books")
            {
                ?>
                <title>Buy And Sell Books Online Australia</title>

                <META name="description" content="Visit Twizla to buy and sell books online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="books online, buy books online, sell books online, books online Australia">

                <?php
            }
            else if($nameOrginal == "Cars & Bikes")
            {
                ?>
                <title>Buy And Sell Cars & Bikes Auction Online</title>

                <META name="description" content="Visit Twizla for cars & bikes auctions online across Australia. The fastest and easiest way to buy and sell cars and bikes today. Free to list and no sales fees.">


                <META name="keywords" content="cars online, bikes online, buy cars online, buy bikes online, cars auction, used cars auction">

                <?php
            }
            else if($nameOrginal == "Computers & Parts")
            {
                ?>
                <title>Buy And Sell Computers & Parts Auction Online</title>

                <META name="description" content="Visit Twizla for computers & parts auctions online across Australia. The fastest and easiest way to buy and sell computers & parts today. Free to list and no sales fees.">


                <META name="keywords" content="buy computers, buy computer parts, sell computers, sell computer parts, computer auctions, computer auction, computers online">

                <?php
            }
            else if($nameOrginal == "Toys & Hobbies")
            {
                ?>
                <title>Buy And Sell Toys Online Australia</title>

                <META name="description" content="Visit Twizla to buy and sell toys online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy toys, sell toys, toys online, buy toys online, sell toys online">

                <?php
            }
            else if($nameOrginal == "DVDs & CDs & Movies")
            {
                ?>
                <title>Buy And Sell DVDs CDs & Movies Online</title>

                <META name="description" content="Visit Twizla to buy and sell DVDs, CDs & movies online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy dvds, buy dvds online, buy cds, buy cds online, buy movies, buy movies online, sell dvds, sell cds, sell movies">

                <?php
            }
            else if($nameOrginal == "Cell Phones & PDAs")
            {
                ?>
                <title>Buy And Sell Mobile Phones Online</title>

                <META name="description" content="Visit Twizla to buy and sell mobile phones online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy mobile phone, buy mobile phones, buy mobile phones online, sell mobile phone, sell mobile phones">

                <?php
            }
            else if($nameOrginal == "Clothes, Shoes & Accessories")
            {
                ?>
                <title>Buy And Sell Clothes Shoes & Accessories Online</title>

                <META name="description" content="Visit Twizla to buy and sell clothes, shoes & accessories online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy shoes, sell shoes, shoes online, clothing online, buy clothes, sell clothes">

                <?php
            }
            else if($nameOrginal == "Coins & Paper Money")
            {
                ?>
                <title>Buy And Sell Coins Paper Money Online</title>

                <META name="description" content="Visit Twizla to buy and sell coins and paper money online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy coins, sell coins, coins online">

                <?php
            }
            else if($nameOrginal == "Jewellery & Watches")
            {
                ?>
                <title>Buy And Sell Jewellery & Watches Online</title>

                <META name="description" content="Visit Twizla to buy and sell jewellery & watches online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy jewellery, sell jewellery, jewellery online, watches online, buy watches, sell watches">

                <?php
            }
            else if($nameOrginal == "Music & Instruments")
            {
                ?>
                <title>Buy And Sell Music & Musical Instruments Online</title>

                <META name="description" content="Visit Twizla to buy and sell music & musical instruments online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy musical instruments, sell musical instruments, musical instruments online">

                <?php
            }
            else if($nameOrginal == "Real Estate")
            {
                ?>
                <title>Buy And Sell Real Estate & Property Auction Online</title>

                <META name="description" content="Visit Twizla for real estate and property auctions online across Australia. The fastest and easiest way to buy and sell real estate and property today. Free to list and no sales fees.">


                <META name="keywords" content="buy real estate, sell real estate, real estate online, property auctions online, property auction online, buy property online, sell property online">

                <?php
            }
            else if($nameOrginal == "Sports")
            {
                ?>
                <title>Buy And Sell Sports Equipment Online</title>

                <META name="description" content="Visit Twizla to buy and sell sports equipment online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy sports equipment, sell sports equipment, sports equipment online">

                <?php
            }
            else if($nameOrginal == "Games")
            {
                ?>
                <title>Buy And Sell Games Online</title>

                <META name="description" content="Visit Twizla to buy and sell games online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy games, sell games, games online, buy games online, sell games online">

                <?php
            }
            else if($nameOrginal == "Pottery & Glass")
            {
                ?>
                <title>Buy And Sell Pottery & Glass Online</title>

                <META name="description" content="Visit Twizla to buy and sell pottery & glass online across Australia. The fastest and easiest way to buy and sell today. Free to list and no sales fees.">


                <META name="keywords" content="buy pottery, sell pottery, games online, pottery online, glass online, buy glass, sell glass">

                <?php
            }
            else
            {
                ?>
                <title>Twizla – Buying And Selling Online Auctions Australia</title>

                <META name="description" content="Visit Twizla Online Auction, a place where buying and selling are made fast and easy.
                      You can register in less than 15 seconds and start your first 30 seconds listing now, IT'S FREE. Buyers can find all kind of products with simple and descriptive information,
                      ready to be won. Twizla will let you taste the joy of buying, selling and online auction in a new experience - Quick and Simple.  ">


                <META name="keywords" content="buy, sell, online auction, twizla, auction, bid">
                <?php
            }
        }
        else
        {
        ?>
            <title>Twizla – Buying And Selling Online Auctions Australia</title>

            <META name="description" content="Visit Twizla Online Auction, a place where buying and selling are made fast and easy.
                  You can register in less than 15 seconds and start your first 30 seconds listing now, IT'S FREE. Buyers can find all kind of products with simple and descriptive information,
                  ready to be won. Twizla will let you taste the joy of buying, selling and online auction in a new experience - Quick and Simple.  ">


            <META name="keywords" content="buy, sell, online auction, twizla, auction, bid">
        <?php
        }
        ?>