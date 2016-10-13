<?php
    
    //initiate the array list of texts in the help page
    $helpHeading = array();
    $helpContent = array();

    //text of "What is Twizla?"
    $content = "Welcome and “G’day. Twizla is a 100% Australian Owned Online Auction Site.<br><br>
                    Twizla is a new website and behind it has very passionate founders to grow the member and listing base, twizla  has revolutioned the online auction industry with a wide range of innovative features, including state of the art technology and exceptional programming to bring online auctions to life.<br><br>
Twizla has paid attention to the online community and has brought useability and simplicity to the website with web 2.0 standards and features such as; complex AJAX scripting to allow for easy navigation and use the ability to purchase and sell products in one step rather than five or six, a portal to external payment system for buyer to seller transactions, video and marketing tools for sellers and many more exciting, innovative ideas to make the online auction process user-friendly and more enjoyable.
";

    $helpHeading[0] = "What is Twizla?";
    $helpContent[0] = $content;

    //text about "Registering"
    $content = "Registration on Twizla is free. There is a simple registration form which we require you to fill in before you can start trading.<br>
<br>
Your Twizla account then is activated immediately afterward and a registration verification email is sent to your email.<br>
<br>
<a href='".$SECURE_PATH."registration/'>Register Now</a><br>
<br>
If haven't received a confirmation email you need to check your junk mail settings aren't blocking our emails. Our emails come from contact@twizla.com.au, you need to add this to your address book.";

    $helpHeading[1] = "Registration";
    $helpContent[1] = $content;

    //text about "Problem logging in"
    $content = "There are several possible reasons why you may not be able to login to Twizla:<br>
<br>
<b>Wrong email / password</b><br>
If you enter the wrong email address and password combination you will see a message telling you that your entry was incorrect. If you cannot remember the password, you can request that a password reminder be sent to your email.
<br><br>
<b>Your cookies are not enabled</b>
<br>
If you do not have cookies enabled, you may not be able to login or use the site correctly.

A cookie is a small file that gets stored on your computer and enables you log in.<br>
Your browser (e.g. Internet Explorer, FireFox) should accept cookies by default. Cookies options can be changed in your browser preferences, which vary depending on which browser you use.
<br>Outlined below is where to go to turn cookies on in the most common browsers:
<br><br>
<table style='font-size:12px;'>
<tr>
    <td><b>Browser</b></td>
    <td><b>Where to find menu options</b></td>
</tr>
<tr>
    <td>Internet Explorer 6 and above</td>
    <td>Tools / Internet Options / Security > Click 'Default Level'</td>
</tr>
<tr>
    <td>Firefox</td>
    <td>Tools / Options / Privacy > Tick 'Accept cookies from sites'</td>
</tr>
<tr>
    <td>Safari</td>
    <td>Edit / Preferences / Security > check 'Accept cookies from sites you navigate to'</td>
</table>
<br>

<b>PC Firewall setting</b><br>
If you have a personal firewall installed (e.g. McAfee Firewall, ZoneAlarm), it may prevent cookie information being sent through. There should be an option in your firewall program to allow cookies. Turn it on to accept cookies.";

    $helpHeading[2] = "Problem logging in";
    $helpContent[2] = $content;


    //text about "Changing your details"
    $content = "You can change your Twizla account details (e.g. email, password, personal details) by accessing :<br>
                <b>My Account</b> > MA > Personal Information tab.";

    $helpHeading[3] = "Changing your details";
    $helpContent[3] = $content;


    //text about "Feedback System"
    $content = "At the end of every auction we encourage the buyer and seller to place feedback about each other. This feedback should represent how the person was to deal with.
<br><br>
By reviewing a member's feedback you can see what other traders thought of their trading behaviour. It will help you assess whether they are a reliable trader or not.
<br><br>
Reviewing a seller's feedback and trading history before bidding is essential and is the best way to protect yourself as a buyer.
<br><br>
The number in brackets next to a trader's username, is their feedback rating - e.g. john (5). Feedback ratings are calculated by taking the total sum of all feedback, with positive feedback as +1 point, negative feedback as -1 point and neutral feedback as 0 point.
<br><br>
A higher feedback rating is given to trader's with more positive feedbacks. The number of stars next to a trader's name represents their feedback rating. The more feedback, the more stars.
<br><br>
A successful transaction can have two feedback records, one from buyer and another from seller. Notes that you can not edit nor remove a feedback after it have been submited.<br>
Therefore, please consider carefully before leaving a feedback. If you left an unaccurate feedback that damage a member reputation, you can face the risk of getting your account banned.
<br><br>
<table style='font-size:12px;'>
    <TR>
        <TD colSpan=5><B>Rating system</B></TD>
    </TR>
    <TR>
        <TD><br></TD>
    </TR>
    <TR>
        <TD align=middle><IMG src='webImages/starball-1.png'> </TD>
        <TD>= 10 to 74 points</TD>
        <TD><div style='width:200px;'></div></TD>
        <TD align=middle><IMG src='webImages/starball-10.png'> </TD>
        <TD>= Power Seller (500 or more sales per month)</TD>
    </TR>
    <TR>
        <TD align=middle><IMG src='webImages/starball-2.png'></TD>
        <TD>= 75 to 149 points</TD>
        <TD><div style='width:200px;'></div></TD>
        <TD></TD>
        <TD></TD>
    </TR>

    <TR>
        <TD align=middle><IMG src='webImages/starball-3.png'></TD>
        <TD>= 150 to 549 points</TD>
        <TD><div style='width:200px;'></div></TD>
        <TD></TD>
        <TD></TD>
    </TR>

    <TR>
        <TD align=middle><IMG src='webImages/starball-4.png'></TD>
        <TD>= 550 to 1499 points</TD>
        <TD><div style='width:200px;'></div></TD>
        <TD></TD>
        <TD></TD>
    </TR>
    <TR>
        <TD align=middle><IMG src='webImages/starball-5.png'></TD>
        <TD>= 1500 to 3499 points</TD>
        <TD><div style='width:200px;'></div></TD>
        <TD></TD>
        <TD></TD>
    </TR>
    <TR>
        <TD align=middle><IMG src='webImages/starball-6.png'></TD>
        <TD>= 4000 to 9999 points</TD>
        <TD><div style='width:200px;'></div></TD>
        <TD></TD>
        <TD></TD>
    </TR>
    <TR>
        <TD align=middle><IMG src='webImages/starball-7.png'></TD>
        <TD>= 10000 to 34999 points</TD>
        <TD><div style='width:200px;'></div></TD>
        <TD></TD>
        <TD></TD>
    </TR>
    <TR>
        <TD align=middle><IMG src='webImages/starball-8.png'></TD>
        <TD>= 35000 to 50000 points</TD>
        <TD><div style='width:200px;'></div></TD>
        <TD></TD>
        <TD></TD>
    </TR>
    <TR>
    <TD align=middle><IMG src='webImages/starball-9.png'></TD>
    <TD>= more than 50000 points</TD></TR>

</table>

";

    $helpHeading[4] = "Feedbacks & Points";
    $helpContent[4] = $content;



        //text about "Search an item"
    $content = "<b>Browse categories</b><br>
There are over 500 categories available on Twizla. You can browse through the categories using the Category tab of the navigation menu bar, then select a category and then a sub category (if required).
<br><br>
<b>Quick search by keywords</b><br>
Enter keywords of an item in the search field. You can also select a category in which to search. Searching by keyword is the quickest way to find an item. You can also enter keywords for an item your looking for at the top of each page.
<br><br>
Tips for searching: Use fewer keywords and avoid using adjectives.
";

    $helpHeading[5] = "Search an item";
    $helpContent[5] = $content;

            //text about "Watch an item"
    $content = "You can keep track of all the items you are watching and bidding from your <a href='".$PROJECT_PATH."account/buy/1/' class='helpLink'>Tag list</a> and <a href='".$PROJECT_PATH."account/buy/2/' class='helpLink'>Bidding list</a>, available from your <a href='".$PROJECT_PATH."account/' class='helpLink'>My Account</a> page.
<br><br>
<b>Adding items to your Tag list</b><br>
You can tag an item clicking the tag image on the item detail page. After that the item will be added to your tag list and an email reminder will be sent to you before the item auction closes.
<br><br>
<b>Adding items to your Bidding list</b><br>
When you bid an item, the item will automatically added to your Bidding list. An email reminder will be sent to you before the item auction closes and afterward to inform you the result.
<br><br>
<b>Manage your lists</b><br>
You can remove a particular item in your lists by clicking at the red cross at the bottom right corner of the item picture. You can also delete the whole list by click the 'Delete All' button.<br>
The items then will be thrown in the <a href='".$PROJECT_PATH."account/buy/4/' class='helpLink'>'Delete list'</a>, which will automatically clear of any item older than 6 months.
";

    $helpHeading[6] = "Watch an item";
    $helpContent[6] = $content;



    //text about "Bidding and Buy Now"
    $content = "Before placing a bid or buy an item you must be a registered user.<br>
        You can either bid or buy an item straight away on the search page by clicking at the buttons of the popup item info panel or go into the item detail page to do the buy/bid.<br>
        <br>
<b>Placing a bid</b><br>
To bid on Twizla is easy, all you have to do is enter your maximum bid and click the 'Bid It!' button.<br>
Your bid must be equal to the start price or the minimum next bid amount for the auction.<br>
If you are outbid you will be sent an email.<br>
If you are the highest bidder at the close of the auction, you are the winner! Twizla will send you and the seller automated emails containing each others contact email addresses. <br>
It is then up to you and the seller to make contact and arrange the payment/shipping details.
<br><br>
<b>Buy Now</b><br>
Buy Now allows the seller to specify a fixed price for the auction at which they are willing to sell the item immediately .<br>
A buyer can choose the buy now option for a fast sale that by-passes the bidding process.<br>
A Buy Now price can only be added before any bids have been placed on an auction.
";

    $helpHeading[7] = "Bidding and Buy Now";
    $helpContent[7] = $content;

    //text about "Item Ratings"
    $content = "You can rate an item on a scale 1 to 5 star using the Rating bar located on the bottom left corner of the Item Detail page.<br><br>
               Each member can only rate an item once. The final item rating will be calculated based on the total of every existing rating for this item.<br><br>
               Items with highest ratings (4, 5 stars) will be displayed in the favourited items list on <a href='".$PROJECT_PATH."buy/' class='helpLink'>Buy page</a> for every members to check out.

";

    $helpHeading[8] = "Item Ratings";
    $helpContent[8] = $content;


    //text about "List an item"
    $content = "Listing an item in Twizla is quick, easy and absolutely FREE.
            To list an item, click the 'Sell' tab and then on the Trolley image.<br><br>

<b>Category</b><br>
Select an appropriate category to list your item. The category of your item will determine where should the buyer find your item on Twizla, thus is very important.
<br><br>
<b>Title and Catch Phrase</b><br>
The 'Item title' should be descriptive to allow people to easily find your item. Try to use clear, concise and relevant keywords to describe your item to assist potential buyers when searching.<br>
The 'Catch Phrase' allows you to catch the attention of buyers in a few words.
<br><br>
<b>Duration</b>
Decide on the Duration of your listing. You can select 3, 5, 7, 10, or 30 days for listings.<br>
After the duration of an item listing is finished and the item is still not sold. It will then be moved into your <a href='".$PROJECT_PATH."account/sell/2/'>unsold item list</a>.
<br><br>
<b>Auction Bid Price and Buy Now Price</b><br>
You can either specify one or both of 'Bid price' and 'Buy price' for an item listing.<br>
The 'Bid price' is the starting bid price of the item when the auction begins. You should set the 'Bid price' at the minimum price you would accept for the item.
<br><br>

<b>Description</b><br>
This is where you describe your item, try to include as much relevant information about the item as you can. For example: the colour, size, condition, specifications, history and other information which can help buyers. HTML (Hypertext Markup Language) is allowed and a WYSIWYG (What you see is what you get) HTML editor is available on the listing page. Learn how to use HTML
<br><br>
<b>Pictures</b><br>
Up to 6 pictures for each item can be added using our picture uploader. The first picture will be shown in search results and category lists as a preview picture.
<br><br>

<b>Payment details</b><br>
Select the payment methods you accept and state your payment instructions clearly. You can select Paymate, PayPal, Bank Deposit, Money Order, C.O.D (Cash On Delivery - A service offered by Australia Post), Credit Card, Cheque, Escrow, Cash or Other.

You can enter default details about payment methods and other information (Bank account details, refund policy, etc) in the 'My Preferences' section in 'My OZtion'.
To enter your default details, please click here.
<br><br>
<b>Postage details</b><br>
There are several postage options to choose from.
<br>
";

    $helpHeading[9] = "List an item";
    $helpContent[9] = $content;

    //text about "Manage your listing"
    $content = "<b>Current Listing Items</b><br>
        You can edit your current listing items through the <a href='listingItemPage1.php'>Sell page</a> (also available from <a href='".$PROJECT_PATH."account/sell/1/'>Selling List</a> on your My Account page.)
        <br>
        Auctions can only be edited if no bids have been placed. Auctions with bids will have a 'Bid' icon float on its top right corner.
<br><br>
<b>Unsold Items</b><br>
You can re-list, edit or delete Unsold items throught through the <a href='listingItemPage1.php'>Sell page</a> or <a href='".$PROJECT_PATH."account/sell/2/'>Unsold list</a> of your My Account Page

";

    $helpHeading[10] = "Manage your listing";
    $helpContent[10] = $content;

    //text about "Safe buying advice"
    $content = "Listed below are some guidelines for safe buying. Combined with your common sense, they will help keep you safe.<br>
<br>
<b>Know your seller</b><br>
Review the member's selling feedback.<br>
Click their feedback rating, then the 'selling' tab. This shows other items they've sold recently and comments from previous buyers.
<br><br>
<b>Know what you're buying</b><br>
Carefully read the item description and answers to questions.<br>
Before you bid you need to know exactly what is being auctioned - including any free accessories, the age and condition of item and even why it's being sold. Poor English may indicate that the seller is overseas or that you may struggle to understand each other.
<br>
Ask your own questions and ensure the seller answers them. Lots of unanswered questions are a danger sign.
<br>
Be very careful of sellers who bypass the auction process.<br>
Please be warning that transactions conducted outside of Twizla will bear a risk of no resolve if they go wrong.
<br>
Beware of fake or pirated goods<br>
Counterfeit items, such as handbags, jewellery and clothing, or unauthorised items such as copies of software, games, music or movies, are illegal and not permitted on Twizla. If you see a listing that looks suspicious, please report it.
<br>
What to look for:
<br><br>
    * If the price of an item seems too good to be true, it probably is. Especially with popular brands.<br>
    * Check the photos on the listing - does it look as it should? Does the packaging look right? Compare the details with products on the brand's own website.<br>
    * Check the seller's reputation and feedback rating
<br><br>
Check the postage costs. Postage typically costs extra and will vary greatly based on the item and your distance from the seller. Make sure you understand the postage costs before bidding. If the seller will let you pick up, we suggest you do.
<br>
<br>
<b>Pay wisely</b><br>
Only pay with our specified payment services. Never pay for goods with Western Union, MoneyGram or instant cash transfers as they cannot be traced.
<br>

Keep all payment details and emails exchanged with the seller.<br>
These details will help us locate the seller if things go wrong.
<br>
<br>
<b>If something does go wrong...</b><br>
Most problems are the result of either poor communication or differing expectations between the buyer and the seller.

Stay in contact with the seller and ensure you understand when to expect delivery. Sellers will typically wait for payment to clear before shipping goods, which can take a couple of days or longer on weekends and bank holidays. Delivery itself can reasonably take another 2-4 business days meaning a possibility of seven days or more between paying and receiving goods.

Frequently buyers and sellers may not be receiving one another's emails due to spam filters or email filtering. Check your junk or bulk email folders.
More on spam filters.

If you have paid and the seller isn't responding to your emails, place a neutral or negative feedback on the seller saying so. This should prompt them into action and serves to warn other buyers.

If you still can't contact the seller after several days, or think you are the victim of fraud, please contact us immediately.

The vast majority of problems reported to us resolve themselves through good communication and patience. So be patient, use your common sense, and happy trading.
";

    $helpHeading[11] = "Safe buying advice";
    $helpContent[11] = $content;

        //text about "Payment Methods"
    $content = "
Before placing a bid or purchasing an item, you should determine which payment methods the seller offers, and which payment methods you feel comfortable using as some payment methods offer more protection than others.
<br>
Read the payment methods and details on the item listing page and then consider the following criteria prior to selecting your payment method.
<br><br>
   1. Is the method of payment you are considering secure and in line with our recommendations outlined in our <a href='".$PROJECT_PATH."help/11/1380/' class='helpLink'>Safe Buying Advice</a>?
<br>
   2. Is the method of payment you are considering convenient for you?
<br>
   3. Does the method of payment you are considering have an option for recourse (is it traceable / refundable) should a dispute arise in due course?
<br><br>
<table id='bigHelpTable' border='1'>
<tr>
    <th>Payment Type</th>
    <th>Information</th>
</tr>
<tr>
    <td><b>Bank Deposit</b></td>
    <td>
Funds are transferred directly into the seller's bank account.
<br>
Advantages:
<br>
    * Deposits may be conveniently paid into the seller's bank account either in person via a bank branch deposit or online via internet banking.<br>
    * Immediate and convenient.<br>
    * Transfers can be fee free most cases. Check transaction fees with the bank.<br>
    * Receipt of payment (proof of payment) can easily be retained through the bank branch or through internet banking.<br>
<br>
Disadvantages:
<br>
    * Payments are extremely difficult to recover in cases of fraud.<br>
    * Transactions using this payment method are not covered by Buyer Shield.<br>
<br>
    </td>
</tr>
<tr>
    <td><b>Paymate</b></td>
    <td>

Paymate is an Australian company that allows online payments to be sent and accepted. Payments can be made by credit card or transferred from a bank account.
<br>
Advantages:
<br>
    * Convenient - Payments can be made after Checkout in Twizla.<br>
    * Payments are deposited directly into the sellers bank account.<br>
    * No registration required for Twizla purchases using credit cards.<br>
    * Pay using an email address anytime, anywhere.<br>
    * Financial and personal details held securely by Paymate.<br>
    * Receipt of payment (proof of payment) can easily be obtained through Paymate.<br>
    * Automatic payment tracking.<br>
    * Buyer Protection of up to $3000 may be offered if certain criteria has been met.<br>
<br>
Disadvantages:<br>

    * Paymate processing fees can apply to both parties.
<br>
<a href='http://www.paymate.com' class='helpLink'>Learn more about Paymate </a>
    </td>
</tr>
<tr>
    <td><b>PayPal</b></td>
<td>

PayPal allows online payments to be sent and accepted. Payments can be made by credit card or transferred from a bank account.
<br>
Advantages:
<br>
    * Immediate and convenient - Payments can be made through Twizla's Checkout.<br>
    * Both the buyer and seller will be able to see 'Cleared' PayPal payments in <a href='".$PROJECT_PATH."account/' class='helpLink'>'My Account'</a>.<br>
    * Pay using an email address anytime, anywhere.<br>
    * Receipt of payment (proof of payment) can easily be obtained through PayPal.<br>
    * Automatic payment tracking.<br>
    * Buyer Protection may be offered if certain criteria has been met.<br>
<br>
Disadvantages:
<br>
    * PayPal processing fees can apply to the seller.<br>

<a href='http://www.paypal.com.au/' class='helpLink'>Learn more about PayPal </a>
    </td>
</tr>
<tr>
    <td><b>eWay</b></td>
<td>

eWay offer an online payment gateway service to process online payment transactions in real time.
<br>
Advantages:
<br>
    * Immediate transaction.<br>
    * Traceable with transaction records from eWay.<br>
<br>
Disadvantages:
<br>
    * Buyer must be a card holder (e.g. credit, master cards).<br>

<a href='http://www.eway.com.au/about/' class='helpLink'>Learn more about eWay </a>
    </td>
</tr>
<tr>
    <td><b>E-gold</b></td>
<td>

E-gold is integrated into an account based payment system that empowers people to use gold as money.<br>
Advantages:
<br>
    * E-gold payment system enables people to Spend specified weights of gold to other e-gold accounts.  Only the ownership changes - the gold in the treasury grade vault stays put<br>.
    * E-gold allow freely transaction between different currency.<br>
    * Traceable with transaction records from e-gold.<br>
<br>

Disadvantages:
<br>
    * Buyer must be a e-gold member.<br>

<a href='http://e-gold.com/unsecure/qanda.html' class='helpLink'>Learn more about e-gold </a>
    </td>
</tr>
<tr>
    <td><b>Moneybookers</b></td>
<td>

Moneybookers enables any business or consumer with an email address to securely and cost-effectively send and receive payments online in real-time.
<br>
Advantages:
<br>
    * Immediate transaction.<br>
    * Traceable with transaction records from Moneybookers.<br>
<br>
Disadvantages:
<br>
    * Both buyer and seller must have Moneybookers account.<br>
    *

<a href='http://www.moneybookers.com/app/help.pl?s=m_info' class='helpLink'>Learn more about eWay </a>
    </td>
</tr>
<tr>
    <td><b>Credit Card</b></td>
    <td>
Secure and efficient method of paying for online purchases, where seller has a credit card merchant account.
<br>
Advantages:
<br>
    * Immediate and convenient.<br>
    * Traceable.<br>
    * Receipt of payment (proof of payment) can easily be obtained from credit card statement.<br>
    * Buyer Protection may be offered if certain criteria has been met.<br>
    </td>
</tr>
<tr>
    <td><b>Cash On Delivery (C.O.D)</b></td>
    <td>
Cash On Delivery (C.O.D) allows for safe and reliable trading. Sellers take the item to a Post Office and complete a lodgment slip. The item is then delivered to the closest Post Office for the recipient to collect. The recipient is then informed there is an article awaiting their collection. Australia Post collect the payment from the buyer and will return any payments due to the seller by money order.
<br>
Advantages:
<br>
    * Easy and safe to use.<br>
    * FREE Extra Cover for items to the value of up to $100 with C.O.D. For items valued from $100 to $5000, addition Extra Cover may easily be purchased.<br>
    * Seller can rely on Australia Post to efficiently finalise the transaction.<br>
    * Buyer is immediately informed when their article is ready for collection.<br>
<br>
Disadvantages:
<br>
    * Postage fees can apply to both parties.<br>
    * If the buyer does not follow through with their purchase, the seller will need to pay for the return postage of the article.<br>
    * Delays of receipt of payment may be experienced by the seller, depending on the buyer and how timely their pick-up is.<br>
<a href='http://www.auspost.com.au/BCP/0,1467,CH2137%257EMO19,00.html' class='helpLink'>Learn more about C.O.D </a>
    </td>
</tr>
<tr>
    <td><b>Personal Cheques and Bank Cheques</b></td>
    <td>
Personal cheques and bank cheques can be sent to the seller via postage, concealed in an envelope. Personal cheques can be issued through the buyer's personal or business cheque account using their cheque book. Bank cheques can be issued over the counter at most banks.
<br>
Advantages:
<br>
    * Receipt of payment (proof of payment) can easily be retained through the tear-off portion attached to the Bank cheque or the personal or business cheque book butt.<br>
    * Can be traced to a postal address.<br>
    * Some cheques can be 'stopped' if a problem arises.<br>
<br>
Disadvantages:
<br>
    * Sellers need to wait for the cheque to arrive by mail and then need to wait for the funds to clear.<br>
    * Payments are extremely difficult to recover in cases of fraud.<br>
    * Transactions using this payment method are not covered by Buyer Shield.<br>
    * Bank fees are normally associated with this method of payment - through the purchase of the bank cheque / issue of the personal or business cheque.
    </td>
</tr>
<tr>
    <td><b>Money Order</b></td>
    <td>
Money Orders are purchased through Australia Post and are mailed to the seller.
<br>
Advantages:
<br>
    * Receipt of payment (proof of payment) can easily be retained through the tear-off portion attached to the Money Order.<br>
    * Can immediately be cashed by the seller at Australia Post once received.<br>
    * Can be traced to a postal address and tracked by Australia Post in order to view the current payment status i.e. whether the money has been received by the Seller.<br>
    * Money Orders can be quickly purchased by anybody, over the counter at any Post Office.<br>
<br>
Disadvantages:
<br>
    * Sellers need to wait for the money order to arrive by mail and then need to wait for the funds to clear if banked.<br>
    * There is no recourse for refunds in cases of fraud.<br>
    * Transactions using this payment method are not covered by Buyer Shield.<br>
    * A purchase fee applies. This cost will be at the buyer's expense.
    </td>
</tr>
<tr>
    <td><b>Escrow</b></td>
    <td>
The buyer makes payment to an escrow service. The seller is notified that payment has been received and sends the item to the buyer. Once the buyer receives and approves the item, the escrow service releases the funds to the seller.
<br>
Advantages:
<br>
    * Payment is held by the escrow service until the buyer receives and approves the item.
<br>
Disadvantages:
<br>
    * Escrow service fees apply.<br>
    * Delays of receipt of payment may be experienced by the seller, depending on the buyer and how timely their action is.
    </td>
</tr>
<tr>
    <td><b>Cash</b></td>
    <td>
Cash can be paid on pick-up of the item (if applicable). NEVER send cash by mail.
<br>
Advantages:
<br>
    * Instant payment / completed transaction when picking an item up.
<br>
Disadvantages:
<br>
    * Cannot be traced.<br>
    * No proof of payment.<br>
    * There is no recourse for refunds in cases of fraud.<br>
    * Transactions using this payment method are not covered by Buyer Shield.<br>
    * Sellers may not receive the cash, due to postage issues (lost or stolen in transit).
    </td>
</tr>
<tr>
    <td><b>Money Transfers and Wire Transfers (Such as Western Union, BidPay & MoneyGram)</b></td>
    <td>
Funds are transferred between third-party agents. Most money transfer services allow people to send money worldwide, through a global network of agents.
<br><br>
Disadvantages:
<br>
    * Cannot be traced.<br>
    * There is no recourse for refunds in cases of fraud.<br>
    * Transactions using this payment method are not covered by Buyer Shield.<br>
    * A high purchase fee will applies. This cost will be at the buyer's expense.
    </td>
</tr>
</table>
";

    $helpHeading[12] = "Payment Methods";
    $helpContent[12] = $content;

        //text about "Term & Condition"
    $content = "
This Agreement lists the Terms & Conditions applicable to your use of our services at http://www.twizla.com.au
<br><OL>
<br><li><b>Eligibility for Membership.</b>
<br>Our services are available only to individuals who can form legally binding contracts under applicable law. Without limiting the foregoing, our services are not available to minors. If you are not 18 or over, you are not entitled to use our services. We may refuse our services to anyone at any time, in our sole discretion. Further, the Services are not available to parties whose use of the Services has been suspended or terminated.
<br>
<br><li><b>No Agency</b>
<br>You and twizla.com.au are independent contractors, and no agency, partnership, joint venture, employee-employer or franchiser-franchisee relationship is intended or created by this Agreement.
<br>
<br><li><b>Equipment.</b>
<br>Twizla.com.au members shall be responsible for obtaining and maintaining all necessary telephone, computer hardware and other equipment needed for access to and use of Twizla.com.au and all charges related thereto.
<br>
<br><li><b>Modifications to Terms and Conditions.</b>
<br>We may change the terms and conditions of this User Agreement from time to time by posting the amended terms and conditions on Twizla.com.au. The amended terms and conditions shall automatically become effective thirty (30) days after they are initially posted. Your continued access and use of Twizla.com.au constitutes:
<br><OL type= 'a'>

<br><li> your acknowledgment of the terms and conditions (and any modifications) of this User Agreement; and <li> your agreement to abide and be bound by the terms and conditions (and any modifications) of this User Agreement. If you do not agree with such changes, you must terminate your membership.
<br></ol>
<br><li><b>Termination by You.</b>
<br>Should you object to any of the terms or conditions of this User Agreement or should you object to any subsequent modifications hereto, or become dissatisfied with Twizla.com.au in any way, your only recourse and sole remedy is to immediately:
<br><OL type='a'>
<br><li> discontinue use of Twizla.com.au; <li> terminate your membership; and <li> notify Twizla.com.au of termination.

</ol>

<br><li><b>Description of Service.</b>
<br>This Auction Site is a venue for sellers to list items for sale and buyers to bid on such items. We are not involved in the actual transaction between sellers and buyers. We have no control over the truth and accuracy of the quality, description, safety or legality of the items for sale. We have no control over whether the sellers have the ability to sell the items or the ability of the buyers to buy the items. We cannot ensure that a seller and buyer will consummate a transaction.
<br>
<br>We are providing you with an auction service to buy and sell products on Twizla.com.au. In consideration of this service, you agree to:
<br><OL type='i'>
<br><li> provide certain current, complete, and accurate information about yourself as prompted to do so and
<br><li> maintain and update this information as required to keep it current, complete and accurate. All information requested when you initially sign up shall be referred to as user registration ('User Registration').
<br></ol>
<br>
<br><li><b>Registration.</b>
<br>You agree to provide true and accurate information about yourself in the registration form. It is a violation of law to make bids in a false name or with an invalid credit card, even if our software initially accepts such a bid.

<br>
<br><li><b>Bidding.</b>
<br>If you are the highest bidder at the end of an auction and your bid is accepted by the seller, you are obligated to complete the transaction with the seller, unless the transaction is prohibited by law or by this Agreement. If you have any questions about the item, have them answered by the seller prior to making your bid. Please read the listing carefully or email the seller if you have any questions. All bids are made in increments-and-are subject to a minimum bid, as posted for each item.
<br>
<br><li><b>Listing and Selling.</b>
<br>Listings may only include text descriptions, graphics and pictures you supply to our site (or that you link to from our site) that describe your item for sale. All listed items must be listed in an appropriate category. All Dutch auction items must be identical - the size, color, make, and model all must be the same for each item. At any one time you may not promote identical items in more than ten (10) listings on Twizla.com.au.
<br>
<br>Placing an item for auction is an irrevocable offer to Sell an item to the highest bidder. Please consider carefully whether you want to place an item for auction. Your opening bid must be the minimum bid that you would accept. When listing items, ensure that the items listed for auction do not infringe upon the Copyright, Trademark or other Rights of those Third parties.
<br>The sale of your item(s) on Twizla.com.au:
<br><ol type='a'>
<br><li> shall not be fraudulent or involve the sale of counterfeit or stolen items;
<br><li> shall not infringe any third party's copyright, patent, trademark, trade secret or other proprietary rights or rights of publicity or privacy; <li> shall not violate any law, statute, ordinance or regulation (including without limitation those governing export control, consumer protection, unfair competition, anti-discrimination or false advertising);

<br><li> shall not be defamatory, trade libelous, unlawfully threatening or unlawfully harassing;
<br><li> shall not be obscene or contain pornography or be otherwise harmful to minors;
<br><li> shall not be directly offensive to that which is dear to people such as their religion or race.
<br><li> shall not contain any viruses, Trojan horses, worms, time bombs, cancelbots or other computer programming routines that are intended to damage, detrimentally interfere with, surreptitiously intercept or expropriate any system, data or personal information;
<br><li> shall not create liability for us or cause us to lose, in whole or in part, the services of our ISP's or other suppliers; and
<br><li> shall not link directly to or include descriptions of goods or services that:
<br><ol type='i'>
<br><li> are identical to other items you have up for auction but are priced lower than your auction item's reserve or minimum bid amount; <li> are listed on a web site that you do not have a right to link to or include;

<br><li> that directly link to another website offering goods of a similar nature;
<br><li> shall not contain advertising banners, graphics or material for any other website or business
<br><li> that state an additional quantity of the same of similar product is available through private sale.
<br></ol>
</ol>

<br>Furthermore, you may not post on our site or sell through our site any:
<br><ol>
<br><li> item that violates any applicable law, statute, ordinance or regulation, or
<br><li> human beings or body parts (relics, skulls, human remains or other parts, advertisements, alcohol, animals and illegal wildlife products, artifacts, bulk email lists, contracts, counterfeit currency and stamps, counterfeit items, credit cards, dangerous and/or hazardous materials, drugs & drug paraphernalia, embargoed goods, pornographic material, firearms, food, freon, government ids and licenses, lottery tickets, obscene items, offensive material, prescription drugs/materials, stocks and other securities, stolen property, soiled undergarments, switchblades, tobacco, used medical devices, and weapons.
<br></ol>

<br><b>Binding Bids.</b>
<br>If you receive at least one bid at or above your stated minimum price (or in the case of reserve auctions, at or above the reserve price), you are obligated to complete the transaction with the highest bidder upon the auction's completion, unless there is an exceptional circumstance, such as:
<br><OL type='a'><li> the buyer fails to meet the terms of your listing (such as payment method), or
<br><li> you cannot authenticate the buyer's identity.
<br></ol>
<br><b>Fraud</b>
<br>Without limiting any other remedies, Twizla.com.au may suspend or terminate your account if you are found (by conviction, settlement, insurance or escrow investigation, or otherwise) to have engaged in fraudulent activity in connection with our site.
<br>
<br><li><b>Fees and Services</b>
<br>There is no cost to join or bid on items for sale on this website. However, there may be costs associated with selling or shipping goods via Twizla.com.au. In this regard, please review our Service Cost Policy, located <a href='".$PROJECT_PATH."help/14/' class='helpLink'>Here</a>, which may change from time to time. Changes to the Service Cost Policy shall become effective after notice is initially posted on this site. Before you list an item you should review the fees that may be charged for the use of our listing services as outlined in our Service Cost Policy. We may in our sole discretion change some or all of our services at any time. If we introduce a new service, the fees for that service are effective at the launch of the service. Unless otherwise stated, all fees are quoted in Canadian dollars.

<br>
<br><li><b>Your Information.</b>
<br>'Your Information' is defined as any information you provide to us or other users in the registration, bidding or listing process, in any public message area (including the feedback area) or through any email feature. You are solely responsible for Your Information, and we act as a passive conduit for your online distribution and publication of Your Information. With respect to Your Information:
<br>Your Information (or any items listed therein):
<ol type='a'>
<br><li> shall not be false, inaccurate or misleading;
<br><li> shall not be fraudulent or involve the sale of counterfeit or stolen items;
<br><li> shall not infringe any third party's copyright, patent, trademark, trade secret or other proprietary rights or rights of publicity or privacy;
<br><li> shall not violate any law, statute, ordinance or regulation (including without limitation those governing export control, consumer protection, unfair competition, antidiscrimination or false advertising);
<br><li> shall not be defamatory, trade libelous, unlawfully threatening or unlawfully harassing;
<br><li> shall not be obscene or contain pornography.

<br><li> shall not contain any viruses, Trojan horses, worms, time bombs, cancelbots or other computer programming routines that are intended to damage, detrimentally interfere with, surreptitiously intercept or expropriate any system, data or personal information;
<br><li> shall not create liability for us or cause us to lose (in whole or in part) the services of our ISPs or other suppliers; and
<br><li> shall not link directly or indirectly to or include descriptions of goods or services that:
<br><ol type='i'>
<br><li> are prohibited under this Agreement;
<br><li> are identical to other items you have up for auction but are priced lower than your item's reserve or minimum bid amount;
<br><li> are concurrently listed for auction on a web site other than Twizla.com.au's; or <li> you do not have a right to link to or include. Furthermore, you may not list any item on our site (or consummate any transaction that was initiated using our service) that, by paying to us the listing fee or the final value fee, could cause us to violate any applicable law, statute, ordinance or regulation.
<br></ol>
</ol>
<br>Solely to enable Twizla.com.au to use the information you supply us with, so that we are not violating any rights you might have in that information, you agree to grant us a non-exclusive, worldwide, perpetual, irrevocable, royalty-free, sublicensable (through multiple tiers) right to exercise the copyright and publicity rights (but no other rights) you have in Your Information, in any media now known or not currently known, with respect to Your Information. Twizla.com.au will only use Your Information in accordance with our Privacy Policy.
<br>
<br><li><b>Account, Password, and Security.</b>*
<br>You are entirely responsible if you do not maintain the confidentiality of your user ID and password. Furthermore, you are entirely responsible for any and all activities that occur under your user ID and password. You agree to immediately notify Twizla.com.au of any unauthorized use of your user ID or any other breach of security that has occurred and is known to you.
<br>
<br><li><b>Breach.</b>
<br>Without limiting other remedies, we may immediately issue a warning, temporarily suspend, indefinitely suspend or terminate your membership and refuse to provide our services to you:
<br><OL type='a'>
<br> <li>if you breach this Agreement or the documents it incorporates by reference;
<br> <li>if we are unable to verify or authenticate any information you provide to us; or
<br> <li>if we believe that your actions may cause legal liability for you, our users or us.

<br></ol>
<br>
<br><li><b>Privacy</b>
<br>Our current Privacy Policy is available <a href='".$PROJECT_PATH."help/15/1650/' class='helpLink'>Here.</a> We may change our Privacy Policy from time to time so we encourage you to periodically review this page for the latest information on privacy practices at Twizla.com.au.
<br>
<br><li><b>Indemnity.</b>
<br>You agree to indemnify and hold us and our subsidiaries, affiliates, officers, directors, agents, and employees, harmless from any claim or demand, including reasonable attorneys' fees, made by any third party due to or arising out of your breach of this Agreement or the documents it incorporates by reference, or your violation of any law or the rights of a third party.
<br>
<br><li><b>Legal Compliance.</b>
<br>You shall comply with all applicable laws, statutes, ordinances and regulations regarding your use of our service and your bidding on, listing, purchase, solicitation of offers to purchase, and sale of items.
<br>

<br><li><b>System Abuse. </b>
<br>We reserve the right to refuse service to anyone. We will exercise this right with 'problem' buyers who win auctions and do not buy the item, and 'problem' sellers who list an item and don't sell the item. Without limiting any other remedies, we may, terminate your registration (and your corresponding ability to use Twizla.com.au) if you are found (by conviction, settlement, insurance or escrow investigation, or otherwise) to have engaged in fraudulent activity in connection with Twizla.com.au.
<br>
<br><li><b>Bid Manipulation.</b>
<br>Bid manipulation of any kind is expressly forbidden. A seller is prohibited from placing bids or arranging to have bids placed on behalf of seller, seller's agent or assigns. No shill bidding is allowed. Buyers are prohibited from communicating with each other with the purpose of manipulating the final purchase price of an item.
<br>
<br><li><b>Illegal Items.</b>
<br>You agree that any transaction that you participate in does not and will not violate any applicable international, federal, state or local laws, rules, regulations or ordinances.
<br>
<br><li><b>Spam.</b>
<br>You agree to refrain from 'spamming' (sending unsolicited commercial email to other users).
<br>
<br><li><b>No Resale or Commercial Use.</b>

<br>Your right to use Twizla.com.au is personal to you. You agree not to resell or make any commercial use of Twizla.com.au, without the express written consent of the Twizla.com.au.
<br>
<br><li><b>Technical Difficulties</b>*
<br>Twizla.com.au can not and does not guarantee continuous, uninterrupted use, and access of our services, due to the fact that loss of quality or operation of our site may be caused by numerous factors, and hence we can not be responsible for bids not being processed or accepted due to technical difficulties outside of our control. If a technical issue arises, Twizla.com reserves the right to stop, restart, or cancel any auction at any time, including before, during and after.
<br>
<br><li><b>Payments And Fees</b>
<br>Any an all payments to Twizla.com for its services are non-refundable. This is true whether or not the item sells. By listing an item for sale on Twizla.com.au, you agree to pay Twizla.com.au all applicable fees based on our then current fee schedule, which is available at Fees, and which is incorporated herein by reference. All fees are non-refundable and, unless otherwise stated, are quoted in U.S. Dollars. You are responsible for paying all applicable taxes and for all hardware, software, service and other costs you incur to bid, buy, procure a listing from us or access our servers. We may in our sole discretion add, delete or change some or all of our services at any time.
<br>
<br><li><b>Maintenance. </b>
<br>We may have maintenance work performed on Twizla.com.au when the need arises, usually once a week. This may or may not cause the Auction Site to be temporarily inaccessible or inoperable. All Auctions listed or ending during this maintenance period will be extended for the time it was not available to users. If necessary, maintenance will be performed at a time when users are least active on Twizla.com.au.
<br>
<br><li><b>Feedback</b>
<br>You may not take any actions that may undermine the integrity of the feedback system. By posting a trade in any of the trading forums you agree to allow other Twizla members to post feedback for you via Twizla.com.au's feedback system, and accept that those posts may be positive or negative. You understand that the only way a 'Bad Trader' listing can be removed is at the request of the original poster. Any attempt to threaten Twizla.com, or any AutionMad.com.au member or owner, or employee to have this feedback removed will cause your access to the site to be removed permenantly. If you earn a sub-standard feedback rating your membership may be terminated, and you will unable to list or bid.

<br>
<br><li><b>Reporting</b>
<br>To report a violation of the terms and conditions of this User Agreement or Twizla.com.au's operating rules or policies, please contact us via the contact form found in the Membership area.
<br>
<br><li><b>Modifications to Service. </b>
<br>The Owner reserves the right to modify or discontinue the services provided on Twizla.com.au with or without notice to you. The Owner shall not be liable to you or any third party should we exercise our right to modify or discontinue any or all services.
<br>
<br><li><b>Owner Endorsement.</b>
<br>You acknowledge and agree that the Owner does not endorse any of the goods that are sold through Twizla.com.au.
<br>
<br><li><b>Proprietary Rights.</b>
<br>By posting messages, uploading files, inputting data, or engaging in any form of communication (collectively, 'Communications') in or through Twizla.com.au, you are granting to the Owner a perpetual, worldwide license (the 'License') to use, copy, modify, adapt or document such Communications. The Owner shall use the Communications solely in conjunction with providing, promoting, distributing or otherwise exploiting Twizla.com.au. The License does not, however, grant the Owner any ownership rights in or to your Communications. You shall have no recourse against the Owner for any alleged or actual infringement of any proprietary rights to which you may claim ownership. The Owner or our vendors own all rights, title and interest in and to all components of Twizla.com.au, but expressly excluding content owned by third parties which may be accessible through Twizla.com.au or the Internet generally. The Owner's ownership rights in Twizla.com.au include, but are not limited to, the look and feel of the end-user interfaces associated with Twizla.com.au, the name of Twizla.com.au, and the collective works consisting of all public messages on Twizla.com.au. You may not reproduce any sequence of messages from Twizla.com.au without the Owner's prior written consent. In addition, you may not copy, modify, adapt, reproduce, translate, distribute, reverse engineer, decompile, or disassemble (a) any aspect of Twizla.com.au that the we or our vendors own, or (b) any service, information or materials supplied by a third party content provider and with you may access through Twizla.com.au.
<br>

<br><li><b>No Agency.</b>
<br>You and the Owner are independent contractors and no agency, partnership, joint venture, employer-employee or franchiser-franchisee relationship is intended or created by this User Agreement or otherwise.
<br>
<br><li><b>General.</b>
<br>If any provision of this User Agreement is held by a court of competent jurisdiction to be contrary to law, then such provision shall be construed, as nearly as possible, to reflect the intentions of the parties with the other provisions remaining in full force and effect. The Owner's failure to exercise or enforce any rights or provisions of this User Agreement shall not constitute a waiver of such right or provision unless acknowledged and agreed to by the Owner in writing. You agree that any cause of action arising out of or related to Twizla.com.au or this User Agreement must commence within one (1) year after the cause of action arose; otherwise, such cause of action is permanently barred. The section titles in this User Agreement are solely used for the convenience of the parties and have no legal or contractual significance.
<br>
<br><li><b>Illegal Activity</b>
<br>The Site and Services only may be used for lawful purposes and in a lawful manner. You may not register under a false name or use an invalid or unauthorized credit card. You may not make bids under a false name, impersonate any participant, or use another participant's password. Such conduct is a violation of state and federal laws. Fraudulent conduct may be reported to law enforcement, and Twizla.com.au will cooperate to ensure all violators will be prosecuted to the full extent of the law.
<br>
<br>Shill bidding is prohibited on Twizla.com.au. Shill Bidding is the placing of bids or causing bids to be placed on any item or product with the aim of artificially increasing or otherwise manipulating the bidding process on Twizla.com.au or the bid price of any product listed on the site.
<br>
<br><li><b>Reservation of Rights</b>
<br>Twizla.com.au retains the right, but does not have the obligation, to immediately halt any auction or product sale, prevent or restrict access to the Site or the Services or take any other action in case of technical problems, objectionable material, inaccurate listings, inappropriately categorized items, auction inaccuracies, product inaccuracies, unlawful items, items, procedures, or actions otherwise prohibited by the procedures and guidelines contained on the Site, or for any other reason in the sole and absolute discretion of Twizla.com.au, and to correct any inaccurate listing, auction inaccuracies, product inaccuracies, inappropriately categorized items or technical problems on the Site.

<br>
<br><li><b>Privacy, Monitoring and Disclosure</b>
<br>Twizla.com.au is committed to protecting your privacy. Our Privacy Policy can be found by <a href='".$PROJECT_PATH."help/15/1650/' class='helpLink' target=_blank>Clicking Here</a> Twizla.com.au reserves the right to change the Privacy Policy, and therefore are adviced to check the Privacy Policy frequently for changes. Except as authorized herein and unless otherwise authorized or consented, you agree not to use any information regarding other users, which is accessible from this Site or disclosed to you by Twizla.com.au, except to enter into and complete transactions. You agree not to use any such information for purposes of solicitation, advertising, unsolicited e-mail or spamming, harassment, invasion of privacy, otherwise objectionable conduct or otherwise inconsistent with our <a href='".$PROJECT_PATH."help/15/1650/' class='helpLink' target=_blank>Privacy policy</a>.
<br>
<br><li><b>Investigation</b>
<br>As permitted by applicable law and consistent with our privacy policy, Twizla.com.au has the right, but not the obligation, to monitor any activity and content associated with this Site. Twizla.com.au may investigate any reported violation of its policies or complaints and take any action that it deems appropriate. Such action may include, but is not limited to, issuing warnings, suspension or termination of service, denying access and/or removal of any materials on the Site, including listings and bids. Twizla.com.au reserves the right and has absolute discretion, to remove, screen or edit any content that violates these provisions or is otherwise objectionable.
<br>
<br><li><b>Disclosure of Information. </b>
<br>As permitted by applicable law, Twizla.com.au also reserves the right to report any activity that it suspects violates any law or regulation to appropriate law enforcement officials, regulators, or other third parties. In order to cooperate with information requests, to protect Twizla.com.au's systems and customers, to allow users to resolve disputes, or to ensure the integrity and operation of Twizla.com.au's business and systems or other purposes deemed reasonable by Twizla.com.au, Twizla.com.au may access and disclose any information it considers necessary or appropriate, including, without limitation, user contact details, IP addressing and traffic information, usage history and posted content.

<br>
<br><li><b>Sale related Disputes.</b>
<br>Because Twizla.com.au is not the seller in the actual transaction between Certified Merchants and buyers and is not the agent of either for any purpose, Twizla.com.au does not have the duty to resolve and will not be involved in resolving any disputes between participants related to or arising out of any such transaction.
<br>
<br><li><b>General Release.</b>
<br><OL type='i'>
<br><li>Since we are not involved in the actual transaction between buyers and sellers, in the event that you have a dispute with one or more users, you release Twizla.com.au (and our officers, directors, agents, subsidiaries and employees) from claims, demands and damages (actual and consequential) of every kind and nature, known and unknown, suspected and unsuspected, disclosed and undisclosed, arising out of or in any way connected with such disputes.
<br><li>You acknowledge and agree that Twizla.com.au is not responsible for the availability of marketplaces, and does not endorse and is not responsible or liable for any services, content, advertising, products or other materials on or available from such marketplaces. you agree that Twizla.com.au shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such services, content, advertising, products or other materials.
<br><li>You acknowledge and agree that Twizla.com.au does not control and is not responsible for information provided by other users which is made available on the site. you may find other user's information to be offensive, harmful, inaccurate or deceptive. you agree that Twizla.com.au shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with the use of or reliance on any such information.
<br></ol>
<br><li><b>Arbitration.</b>
<br>Any controversy or claim arising out of or in connection with this Agreement may at our discretion be settled by binding arbitration by reference to a commercial disputes centre. You agree to be bound by the ruling arbitrator. The costs of the dispute are borne by the originator.

<br>
<br><li><b>DISCLAIMER OF WARRANTIES.</b>
<br>YOU EXPRESSLY AGREE THAT USE OF Twizla.com.au IS AT YOUR SOLE RISK. THE AUCTION SITE IS PROVIDED AND MADE AVAILABLE ON AN 'AS IS' AND 'AS AVAILABLE' BASIS. THE OWNER EXPRESSLY DISCLAIMS ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. THE OWNER MAKES NO WARRANTY THAT Twizla.com.au WILL MEET YOUR REQUIREMENTS, OR THAT ACCESS TO AND AVAILABILITY OF Twizla.com.au WILL BE UNINTERRUPTED, TIMELY, SECURE, OR ERROR FREE; NOR DOES THE OWNER MAKE ANY WARRANTY AS TO THE RESULTS THAT MAY BE OBTAINED FROM THE USE OF Twizla.com.au OR AS TO THE ACCURACY OR RELIABILITY OF ANY INFORMATION PUBLISHED ON Twizla.com.au. THE OWNER MAKES NO WARRANTY REGARDING ANY GOODS OR SERVICES PURCHASED OR OBTAINED THROUGH Twizla.com.au OR ANY TRANSACTIONS ENTERED INTO AS A RESULT OF Twizla.com.au. NO ADVICE OR INFORMATION, WHETHER ORAL OR WRITTEN, OBTAINED BY YOU FROM THE OWNER OR THROUGH Twizla.com.au SHALL CREATE ANY WARRANTY NOT EXPRESSLY MADE HEREIN. SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF CERTAIN WARRANTIES, SO SOME OF THE ABOVE EXCLUSIONS MAY NOT APPLY TO YOU.
<br>
<br><li><b>LIMITATION OF LIABILITY.</b>
<br>THE OWNER (AND ITS EMPLOYEES, OFFICERS, DIRECTORS, AND VENDORS) SHALL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES, RESULTING FROM THE USE OR THE INABILITY TO USE Twizla.com.au, OR FOR COST OF PROCUREMENT OF SUBSTITUTE GOODS AND SERVICES, OR RESULTING FROM ANY GOODS OR SERVICES PURCHASE OR OBTAINED, OR MESSAGES RECEIVED OR TRANSACTIONS ENTERED INTO THROUGH Twizla.com.au OR RESULTING FROM UNAUTHORIZED ACCESS TO, OR ALTERATION OF YOUR TRANSMISSIONS OR DATA, INCLUDING BUT NOT LIMITED TO, DAMAGES FOR LOSS OF PROFITS, USE, DATA OR OTHER INTANGIBLE, EVEN IF THE OWNER HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. SOME JURISDICTIONS DO NOT ALLOW THE LIMITATION OR EXCLUSION OF LIABILITY FOR INCIDENTAL OR CONSEQUENTIAL DAMAGES SO SOME OF THE ABOVE LIMITATIONS MAY NOT APPLY TO YOU.
<br>
<br><li><b>Indemnification.</b>
<br>You agree to indemnify and hold the Owner, its parents, subsidiaries, affiliates, officers, employees and vendors, harmless from any claim or demand, including reasonable attorneys' fees, due to or arising out of your use of Twizla.com.au, your violation or breach of this User Agreement, or your infringement of any intellectual property or other right of any person or entity.
<br>
<br><li><b>General</b>
<br>Headings are for reference purposes only and in no way define, limit, construe or describe the scope or extent of such section. Our failure to act with respect to a breach by you or others does not waive our right to act with respect to subsequent or similar breaches. You agree that this Agreement may not be construed adversely against us solely because we prepared it. This Agreement and the terms and conditions incorporated herein set forth the entire understanding and agreement between us with respect to the subject matter hereof.
<br>
<br>Parental control filtering software is commercially and freely available that may assist you in limiting access to material that is harmful to persons under the age of 18 years. Freely available parental control software: <a href=http://www.bigpond.com/cybersafety/ target=_blank>Parental Filter</a>.
<br></ol>

";

    $helpHeading[13] = "Terms & Conditions";
    $helpContent[13] = $content;

        //text about "Fees"
    $content = "<table width=600 cellpadding='3' cellspacing=2 align=center style='font-size:12px;'>
                    <tr>
                        <td colspan='3' bgcolor=#ee0072 align=center><font size=2 color=white face=arial><B>Twizla Listing Fees</B></font></Td>
                    </tr>
                    <tr>
                        <td width='205' bgcolor='#cacaca'  style='color:#222;'>&nbsp;<strong>Basic listing</strong></td>
                        <td width='98' bgcolor='#e9edee'  style='color:#222;'>FREE</td>
                        <td width='280' bgcolor='#e9edee' style='color:#222;'><font color='#FF0000'></font></td>
                    </tr>
                    <tr>
                        <td bgcolor='#cacaca' style='color:#222;'><strong>&nbsp;Front page featured</strong></td>
                        <td bgcolor='#e9edee' style='color:#222;'<FREE</td>
                        <td bgcolor='#e9edee' style='color:#222;'>Listings will be randomly shown on the Twizla front page.</td>
                    </tr>
                    <tr>
                        <td bgcolor='#cacaca' style='color:#222;'><strong>&nbsp;Featured</strong></td>
                        <td bgcolor='#e9edee' style='color:#222;'>FREE </td>
                        <td bgcolor='#e9edee' style='color:#222;'>Listing will be shown as featured.</td>
                    </tr>
                    <tr>
                        <td bgcolor='#cacaca' style='color:#222;'><strong>&nbsp;Bold listing</strong></td>
                        <td bgcolor='#e9edee' style='color:#222;'>FREE</td>
                        <td bgcolor='#e9edee' style='color:#222;'></td>
                    </tr>
                    <tr>
                        <td bgcolor='#cacaca' style='color:#222;'><strong>&nbsp;Highlight listing</strong></td>
                        <td bgcolor='#e9edee' style='color:#222;'>FREE</td>
                        <td bgcolor='#e9edee' style='color:#222;'></td>
                    </tr>
                    <tr>
                        <td bgcolor='#cacaca' style='color:#222;'>&nbsp;<strong>Buy Now </strong></td>
                        <td bgcolor='#e9edee' style='color:#222;'>FREE</td>
                        <td bgcolor='#e9edee' style='color:#222;'></td>
                    </tr>
                    <tr>
                        <td bgcolor='#cacaca' style='color:#222;'>&nbsp;<strong>Bid Auction</strong></td>
                        <td bgcolor='#e9edee' style='color:#222;'>FREE</td>
                        <td bgcolor='#e9edee' style='color:#222;'>FREE!!</td>
                    </tr>
                    <tr>
                        <td colspan='3' align=center><br></td>
                    </tr>
                    <tr>
                        <td colspan='3' align=center><i>Prices are subject to Change please review this page often.</i></td>
                    </tr>
                    <br>
                    <tr>
                        <td colspan=3 align=center>Happy Buying and Selling at Twizla</td>
                    </tr>
                    </table>
                    <br>
                    <br><center>Last Updated: 01-Feb-2010</center>
                    <br>
";
//                    <tr>
//                        <td><strong>&nbsp;Auto-Relist</strong></td>
//                        <td>FREE</td>
//                        <td >Re-list automatically at the end if it is not sold.</td>
//                    </tr>
    $helpHeading[14] = "Fees";
    $helpContent[14] = $content;
    
        //text about "Privacy Policy"
    $content = "
<UL>
<br><li><B>What this Privacy Policy Covers</b>
<br><UL><li>This Privacy Policy covers Twizla.com.au's treatment of personally identifiable information that Twizla.com.au collects when you are on the Twizla.com.au site, and when you use Twizla.com.au's services.  This policy also covers Twizla.com.au's treatment of any personally identifiable information that Twizla.com.au's business partners share with Twizla.com.au or that Twizla.com.au may collect on a partner's site.
<br><li>This policy does not apply to the practices of companies that Twizla.com.au does not own or control, or to people that Twizla.com.au does not employ or manage.

<br></ul>
<br><li><b>Information Collection and Use</b>
<br><UL><li>Twizla.com.au collects personally identifiable information when you register for a Twizla.com.au account, when you use certain Twizla.com.au products or services, when you visit Twizla.com.au pages. Twizla.com.au may also receive personally identifiable information from our business partners.
<br><li>When you register with Twizla.com.au, we ask for your name, email address, and zip code etc. Once you register with Twizla.com.au and sign in to our services, you are not anonymous to us.
<br><li>Twizla.com.au also automatically receives and records information on our server logs from your browser including your IP address, Twizla.com.au cookie information and the page you requested.
<br><li>Twizla.com.au uses information for three general purposes: to customize the advertising and content you see, to fulfill your requests for certain products and services. </ul>
<br><li><B>Information Sharing and Disclosure</b>
<br><UL><li>Twizla.com.au is very protective of your privacy. We do not sell or rent your personal information to a third party for marketing purposes without your prior approval.
<br><li>Twizla.com.au may send personally identifiable information about you if:
<br><UL><li>We respond to subpoenas, court orders or legal process; or
<br><li>We find that your actions on our web sites violate the <a href='".$PROJECT_PATH."help/13/6680/' target=_blank>Twizla.com.au Terms of Service</a></ul></ul>
<br><li><b>Cookies</b>

<br><UL><li>Twizla.com.au may set and access Twizla.com.au cookies on your computer.
<br></ul>
<br><li><b>Your Ability to Edit and Delete Your Account Information and Preferences</b>
<br><UL><li>Twizla.com.au gives you the ability to edit your Account preferences at any time in the Member section.
<br><li>You may request Termination of your Twizla.com.au account by the contact form found in the Member section.
<br></ul>
<br><li><b>Security</b>
<br><UL><li>Your Twizla.com.au Account Information is password-protected for your privacy and security.
<br><li>In certain areas Twizla.com.au uses industry-standard SSL-encryption to protect data transmissions.
<br></ul>
<br><li><b>Sharing</b>
<br><UL>
<br><li>Twizla.com.au shares only essential information with other Members of Twizla.com.au to facilitate completion of transactions or for questions regarding an item.
<br><li>Twizla.com.au use a credit card processing company to bill users for goods and services. These companies do not retain, share, store or use personally identifiable information for any secondary purposes.

<br></ul>
<br><li><b>Links</b>
<br><UL><li>Twizla.com.au contains links to other sites. Please be aware that Twizla.com.au are not responsible for the privacy practices of such other sites.  We encourage our users to be aware when they leave our site and to read the privacy statements of each and every web site that collects personally identifiable information.  This privacy statement applies solely to information collected by this Web site.
<br></ul>
<br><li><b>Site and Service Updates</b>
<br><UL><li>Twizla.com.au may send the user site and service announcement updates. Members are not able to un-subscribe from service announcements, which contain important information about the service. We will communicate with members to provide requested services and issues relating to their account via email.
<br></ul>
<br><li><b>Changes to this Privacy Policy</b>
<br><UL><li>Twizla.com.au may amend this policy from time to time. Please check this page regularly.
<br></ul>
";

    $helpHeading[15] = "Privacy Policy";
    $helpContent[15] = $content;



    //text about "Registering"
    $content = "
<b>HOW TO ENTER THE DRAW:</b>
<br><br>
To be elegable for this offer, simply complete a member registration anywhere on Twizla’s website between 25/03/10 and 11/06/10. Be online at 12pm AEST on the 11th of June 2010 for a live draw.
<br><br>
<b>Terms and Conditions</b>
<br><br>
1. On how to redeem the offer forms part of these Terms and Conditions. Participation in this promotion is deemed acceptance of these Terms and Conditions.
<br><br>
2. Entry is only open to Australian residents. Employees of the Promoter, participating stores, the Promoter’s associated companies, the Promoter’s agencies associated with this promotion and their immediate families are ineligible to enter. Entrants must be over 18 years old to enter.
<br><br>
3. The offer commences at 12pm AEST on 25/03/10 and closes 12am at 11/06/10 ('Offer Period').
<br><br>
4. The Promoter reserves the right to verify the validity of redemptions, at any time during or after the promotion, and reserves the right to disqualify any entrant (and ALL redemptions submitted by that entrant) for tampering with the redemption process. Failure of the Promoter to enforce any of its rights at any stage does not constitute a waiver of those rights.
<br><br>
5. Cost of accessing the internet is the entrant’s responsibility. Any costs associated with accessing the promotional website are the entrant’s responsibility and are dependent on the internet service provider used. Any contact details entered incorrectly shall invalidate the entry. The Promoter is not responsible for receipt of incomplete or incomprehensible entries. All such inaccurate entries will be deemed invalid. No responsibility is accepted for late, lost or misdirected entries. Any entry that does not comply with these Terms and Conditions will be invalid.
<br><br>
6. The Promoter accepts no responsibility for any variation in the offer value.
<br><br>
7. The Promoter is not liable for any loss or damage whatsoever which is suffered (including but not limited to indirect or consequential loss) or for any personal injury suffered or sustained in connection with taking the prize, except for any liability which cannot be excluded by law.
<br><br>
8. In the event of war, terrorism, state of emergency or disaster the Promoter reserves the right to cancel, terminate, modify or suspend the promotion subject to any written directions from a relevant Regulatory Authority.
<br><br>
9. The Promoter is not responsible for any incorrect or inaccurate information, either caused by the telephone or internet user or for any of the equipment or programming associated with or utilised in this promotion, or for any technical error, or any combination thereof that may occur in the course of the administration of this promotion including any omission, interruption, deletion, defect, delay in operation or transmission, communications line or telephone, mobile or satellite network failure, technical problems or traffic congestion on the internet or website, software failure, theft or destruction or unauthorised access to or alteration of entries and any injury or damage to participants or any other person’s computer related to or resulting from participating in or downloading any materials in the promotion. If for any reason this promotion is not capable of running as planned, including but not limited to technical failures, unauthorised intervention, fraud or any other cause beyond the control of the Promoter which corrupts or affects the administration, security, fairness, integrity or proper conduct of this promotion, the Promoter reserves the right in its sole discretion to disqualify any individual who tampers with the entry process, and, subject to any written directions given by a relevant Regulatory Authority, to cancel, terminate, modify or suspend the promotion.
<br><br>
10. All redemptions become the property of the Promoter. The Promoter collects entrants’ personal information in order to conduct the promotion. If the information requested is not provided, the entrant may not participate in the promotion. By entering this promotion, unless otherwise advised, each entrant also agrees that the Promoter may use this information, in any media for future promotional, marketing and publicity purposes without any further reference, payment or other compensation to the entrant, including sending the entrant electronic messages. Entrants’ personal information may be disclosed to State and Territory lottery departments and winners’ names published as required under the relevant lottery legislation. A request to access, update or correct any information should be directed to the Promoter at its address set out below. Promoter’s privacy policy can be viewed at www.unilever.com.au/resources/privacy.asp
<br><br>
11. Entrants consent to the Promoter using the entrant’s name, likeness, image and/or voice in the event they are a winner (including photograph, film and/or recording of the same) in any media for an unlimited period of time without remuneration for the purpose of promoting this promotion (including any outcome), and promoting any products manufactured, distributed and/or supplied by the Promoter.
<br><br>
12. The Promoter reserves the right to request winners to provide proof of age, identity and residency at the nominated prize delivery address. Identification considered suitable for verification is at the discretion of the Promoter.
<br><br>
13. The Promoter is Twizla Pty Ltd ABN 14 136 718 119  P.O Box 1909 Bondi Junction NSW 2022.
";
    $helpHeading[16] = "Terms & Conditions of the Draw";
    $helpContent[16] = $content;


    //text about "How to import a CSV inventory fileg"
    $content = "
<b>How to import a CSV inventory file:</b>
<br><br>
It's simple to import a CSV file on Twizla. Your CSV file only need to follow 3 rules:
<br><br>
    1. The inventory file must have its fields separated by a comma (,).
<br><br>
    2. Every item row should follow the format (see example at bottom):
    <br><br>
    Title, Category_ID, CatchPhrase, Description, Buy Now Price, Starting Bid Price, Postage, Condition, Quantity, ImageURL, ImageURL2,...
    <br><br>
    3. You must include the required fields from the table below, leave out the optional field by starting the next comma (,,):
<br><br>

<table border='1' style='font-size:12px;'>
<tr>
<th>Field Name</th>
<th>Data Expected</th>
<th>Occurrence</th>
<th>Example Data</th>
</tr>
<tr>
<td>ItemTitle</td>
<td>The title / name of your item (up to 50 characters)</td>
<td>Required</td>
<td style='width:200px;'>Cute Piggie Toy</td>
</tr>
<tr>
<td>Category_ID</td>
<td>The numeric ID represent the category for your item. For CSV import, you can only assign items to the top category layer.<br>
Please check the CategoryIDs <a href='".$PROJECT_PATH."help/18/6580/'>listed here</a>.</td>
<td>Required</td>
<td style='width:200px;'>320</td>
</tr>
<tr>
<td>CatchPhrase</td>
<td>The fact about your item that shall bring the interest of buyers.</td>
<td>Optional</td>
<td style='width:200px;'>Cute and cheap piggie.</td>
</tr>
<tr>
<td>Description</td>
<td>Description of your item.</td>
<td>Required</td>
<td style='width:200px;'>Small cute pig toy, can be used as a pillow.</td>
</tr>
<tr>
<td>Buy Now Price / Starting Bid Price</td>
<td>The prices for item to buy on the spot or starting the auction from.</td>
<td>Required one of the two fields</td>
<td style='width:200px;'>32</td>
</tr>
<td>Postage</td>
<td>The method for shipping your item, pick from the following 3 options:
    <br><br>
    1. Fixed Price (Shipping Cost)<br>
    2. Free shipping<br>
    3. Self Pick Up<br>
    <br><br>
</td>
<td>Required</td>
<td style='width:200px;'>Fixed Price 24<br>
    Free shipping<br>
    Self Pick Up
</td>
</tr>
<td>Condition</td>
<td>The current condition of your item, by default it's 'Good Condition'</td>
<td>Optional</td>
<td style='width:200px;'>Good condition</td>
</tr>
<td>Quantity</td>
<td>The number of item that you want to list.</td>
<td>Required</td>
<td style='width:200px;'>10</td>
</tr>
<td>ImageURL</td>
<td>This field should contain the full URL  image link for your item (e.g., http://i776.photobucket.com/albums/yy47/CortneaPaiige/CACJADKN.jpg). <br>
Every item row need at least one image field, you can add up to 6 image field as necessary.
</td>
<td>Required</td>
<td style='width:200px;'>http://i776.photobucket.com/albums/yy47/CortneaPaiige/CACJADKN.jpg</td>
</tr>
</table>
<br><br>
<b>Example CSV file:</b>
<br><br>
The CSV file content should have the following format:<br><br>
Pig Toy, Category_ID, Cute and cheap piggie., Small cute pig toy, can be used as pillow., 20, 5, Fixed Price 5, Brand New, 10, http://i776.photobucket.com/albums/yy47/CortneaPaiige/CACJADKN.jpg<br>
LCD TV, Category_ID,, New Samsung TV for sale, 1500, 600, Self Pick Up,, 5, http://i776.photobucket.com/albums/yy48/LCDTV/TV.jpg,http://i776.photobucket.com/albums/yy48/LCDTV/TV2.jpg
";
    $helpHeading[17] = "How to import a CSV inventory file";
    $helpContent[17] = $content;

    //text about "List of Category IDs"
    
    $content = "<b>Search for a Category:</b>
        <br><br>
        <input type='text' id='searchStr'><button onclick='searchCategory()'>Search</button>
        <br><br>
        ";


    $conn = dbConnect();
    if(isset($_GET['searchStr']))
    {
        $content .= "<a href='".$PROJECT_PATH."help/18/6580/' class='helpLink'>>> Back to the complete category list</a><br><br>";
        $sql = "SELECT * FROM category, subcategory WHERE category.CategoryID = subcategory.CategoryID AND 
                                                        (subCategoryName LIKE '%".$_GET['searchStr']."%' OR CategoryName LIKE '%".$_GET['searchStr']."%')
                                                            ORDER BY category.CategoryID, subcategory.subCategoryID ASC";

        $result = mysql_query($sql) or die(mysql_error());

        while($row = mysql_fetch_array($result))
        {
            $list[] = $row;
        }

        if(count($list) == 0)
        {
            $content .="There are no category matched ".$_GET['searchStr'].".";
        }
        else
        {
            $content .="List of categories found for '".$_GET['searchStr']."'";
            if(count($list) > 30)
            {
                $content .= " (limited to 30 results):";
            }
            $content .=" <br><br>";

            $content .= "
            <table border='1' >
            <tr>
            <th>Parent Category</th>
            <th>Category ID</th>
            <th>Category Name</th>
            </tr>";

            $count = 0;
            foreach($list as $category)
            {
                if($count > 30)
                {
                    break;
                }
                $content .= "<tr><td>".$category['CategoryName']."</td>";
                $content .= "<td>".$category['subCategoryID']."</td>";
                $content .= "<td>".$category['subCategoryName']."</td>";
                $content .= "</tr>";
                $count ++;

            }

            $content .= "</table>";

        }


    }
    else
    {
    $content .= "<b>Complete List of Top Category Layers:</b>
    <br><br>
    <table border='1' >
    <tr>
    <th>Parent Category</th>
    <th>Category ID</th>
    <th>Category Name</th>
    </tr>";


        // get the list of category from database
        $sql = "SELECT * FROM category ORDER BY CategoryID ASC";

        $result = mysql_query($sql) or die(mysql_error());

        while($row = mysql_fetch_array($result))
        {
            $list[] = $row;
        }

        foreach($list as $category)
        {

            $sql = "SELECT * FROM subcategory WHERE CategoryID = ".$category['CategoryID']." ORDER BY subCategoryID ASC";

            $result = mysql_query($sql) or die(mysql_error());

            while($row = mysql_fetch_array($result))
            {
                $content .= "<tr><td>".$category['CategoryName']."</td>";
                $content .= "<td>".$row['subCategoryID']."</td>";
                $content .= "<td>".$row['subCategoryName']."</td>";
                $content .= "</tr>";
            }

        }

        $content .= "</table>";

    }
    mysql_close($conn);

    $helpHeading[18] = "List of top category layer";
    $helpContent[18] = $content;

?>
