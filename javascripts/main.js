

var projectPath = "http://www.twizla.com.au/";
//var projectPath = "http://localhost/Twizla/";




//Function to create the press button effect
//
//function buttonPress(buttonImg)
//{
//
//}
//
//function buttonRelease(buttonImg)
//{
//
//}

//Function to search for category in help Page

function searchCategory()
{
    var searchStr = document.getElementById("searchStr").value;
    if(searchStr != "")
    {
        window.location = projectPath + 'help/18/1550/' + searchStr + "/";
    }
}


//End Function to search for category in help Page


//Function to animate the new message warning bubble


function moveBubbleUp()
{
    var bubble = document.getElementById("newMessageBubble");
    bubble.style.top = 68 + "px";
    setTimeout("moveBubbleDown()", 250 );
}

function moveBubbleDown()
{
    var bubble = document.getElementById("newMessageBubble");
    bubble.style.top = 70 + "px";
    setTimeout("moveBubbleUp()", 250 );
}

//End Function to animate the new message warning bubble



//Function to create the fade effects in the home page

/* set the opacity of the element (between 0.0 and 1.0) */
function setOpacity(level, element)
{
      element.style.opacity = level;
      element.style.MozOpacity = level;
      element.style.KhtmlOpacity = level;
      element.style.filter = "alpha(opacity=" + (level * 100) + ");";
}

function setFirstPicOpacity(level)
{
      var element = document.getElementById("homeLogInBanner");
      setOpacity(level, element);
}

function setSecondPicOpacity(level)
{
      var element = document.getElementById("lotusPicture");
      setOpacity(level, element);
}


var duration = 1000;  /* 1000 millisecond fade = 1 sec */
var steps = 25;       /* number of opacity intervals   */
var delay = 5000;     /* 5 sec delay before fading out */

function fadeIn()
{

  for (i = 0; i <= 1.1; i += (1 / steps))
  {
    setTimeout("setFirstPicOpacity(" + i + ")", i * duration);
    setTimeout("setSecondPicOpacity(" + (1 - i) + ")", i * duration);
  }
  setTimeout("fadeOut()", delay);
}

function fadeOut() {
  for (i = 0; i <= 1.1; i += (1 / steps))
  {
    setTimeout("setFirstPicOpacity(" + (1 - i) + ")", i * duration);
    setTimeout("setSecondPicOpacity(" + i + ")", i * duration);
  }
  setTimeout("fadeIn()", delay);
}


//End Function to create the fade effects in the home page



//Function to limit the character number of textare
function limitText(limitField, limitNum)
{
    if (limitField.value.length > limitNum)
    {
            limitField.value = limitField.value.substring(0, limitNum);
    }
    else
    {
        var wordCount = document.getElementById('wordCount');
        var charLeft = (limitNum - limitField.value.length);
        wordCount.innerHTML="<i>" + charLeft + " characters left." + "</i>";
    }
}
//End Function to limit the character number of textare

// *****Head Section *************************************************************
// Function to submit form on pressing enter
function submitEnter(form)
{

    var keycode;

    if (window.event)
    {
        keycode = window.event.keyCode;

    }
    else
    {
        return true;
    }

    if (keycode == 13)
    {
       form.submit();
    }


}

//
//End Function to submit form on pressing enter
//
//function displayRegisterButton()
//{
//    var registerButton = document.getElementById("registerButton");
//
//    if(registerButton != null)
//    {
//
//
//        var borderTop = document.getElementById("middeBorderBoxTop");
//
//        var registerButtonSize = 40;
//        var registerButtonMargin = 3;
//        var loginBox = document.getElementById("loginForm");
//        if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) //test for Firefox/x.x or Firefox x.x (ignoring remaining digits);
//        {
//
//            registerButton.style.top = borderTop.offsetTop - registerButtonSize - registerButtonMargin*2 + "px";
////            registerButton.style.top = 271 + "px";
//            registerButton.style.left = loginBox.offsetLeft + 90 + "px";
//        }
//        else if (!(/MSIE (\d+\.\d+);/.test(navigator.userAgent))) //test for MSIE x.x;
//        {
//            registerButton.style.position = 'relative';
//            registerButton.style.top = '135px';
//            registerButton.style.left =  '90px';
//
////            registerButton.style.top = borderTop.offsetTop - registerButtonSize - registerButtonMargin*2 - 14 + "px";
////            registerButton.style.left = registerButton.offsetLeft + 90 + "px";
//        }
//    }
//}
//
//
//function displayRegisterComment()
//{
//    var registerButton = document.getElementById("registerButton");
//    var registerComment = document.getElementById("registerComment");
//    var registerButtonSize = 40;
//    var registerButtonMargin = 12;
//
//    //set the position of the resigter comment to be align with register button
//    //depend on the type of browser, some left & top offset will be added in to make the right pos of the comment
//
////    if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) //test for Firefox/x.x or Firefox x.x (ignoring remaining digits);
////    {
////        registerComment.style.left = registerButton.offsetLeft + 3 + "px";
////        registerComment.style.top = registerButton.offsetTop + registerButtonSize + registerButtonMargin + "px";
////    }
////    else
//    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) //test for MSIE x.x;
//    {
//
//        registerComment.style.top = findPosY(registerButton) + registerButtonSize + registerButtonMargin - 5 + "px";
//        registerComment.style.left = registerButton.offsetLeft + 43 + "px";
//
//    }
//    else
//    {
//        registerComment.style.left = registerButton.offsetLeft + 5 + "px";
//        registerComment.style.top = registerButton.offsetTop + registerButtonSize + registerButtonMargin + "px";
//    }
//
//
//    registerComment.style.visibility  = "visible";
//}
//
//function hideRegisterComment()
//{
//    var registerComment = document.getElementById("registerComment");
//    registerComment.style.visibility  = "hidden";
//}

// End Functions to display the register comment
// Functions to display/hide the category list drop down menu
function hideCategoryList()
{
    var list = document.getElementById("categoryListPanel");
    list.style.visibility = 'hidden';
}

function displayCategoryList()
{
    var categoryMenu = document.getElementById("categoryMenu");
    var list = document.getElementById("categoryListPanel");

    //align the categoryListPanel with the categoryMenu based on the browser
//    if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) //test for Firefox/x.x or Firefox x.x (ignoring remaining digits);
//    {
//        list.style.left = findPosX(categoryMenu) + "px";
//        list.style.top = findPosY(categoryMenu)  + 37 + "px";
//    }
//    else
    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) //test for MSIE x.x;
    {
        list.style.left = (categoryMenu.offsetLeft - 557)  + "px";
        list.style.top = findPosY(categoryMenu) ;
    }
    else
    {
        list.style.left = (findPosX(categoryMenu) - 317) + "px";
        list.style.top = findPosY(categoryMenu)  + 25 + "px";
    }

    list.style.visibility = 'visible';

}
// End Functions to display/hide the category list drop down menu
// Functions to get the absolute position of an element in the page


function findPosX(obj)
{
    var curleft = 0;
    if(obj.offsetParent)
        while(1)
        {
          curleft += obj.offsetLeft;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
}

function findPosY(obj)
{
    var curtop = 0;
    if(obj.offsetParent)
        while(1)
        {
          curtop += obj.offsetTop;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.y)
        curtop += obj.y;
    return curtop;
}
// End Functions to get the absolute position of an element in the page
// *****Head Section *************************************************************

//Functions to manipulate tabs view
// ***** Auxiliary *************************************************************

function tabview_aux(TabViewId, CurrentId)
{
  var TabView = document.getElementById(TabViewId);

  // ***** Tabs *****

  var Tabs = TabView.firstChild;
  while (Tabs.className != "Tabs") Tabs = Tabs.nextSibling;
  var Tab  = Tabs   .firstChild;
  var i    = 0;

  do
  {
    if (Tab.tagName == "A")
    {
      i++;
      Tab.href         = "javascript:tabview_switch('"+TabViewId+"', "+i+");";
      Tab.className    = (i == CurrentId) ? "Current" : "";
      Tab.blur();
    }
  }
  while (Tab = Tab.nextSibling);

  // ***** Pages *****

  var Pages = TabView.firstChild;
  while (Pages.className != 'Pages') Pages = Pages.nextSibling;
  var Page  = Pages  .firstChild;
  var i     = 0;

  do
  {
    if (Page.className == 'Page')
    {
      i++;
      if (Pages.offsetHeight) Page.style.height = (Pages.offsetHeight-2)+"px";
      Page.style.display  = (i == CurrentId) ? 'block' : 'none';
    }
  }
  while (Page = Page.nextSibling);
}


// ***** Tab View **************************************************************

function tabview_switch(TabViewId, id) {tabview_aux(TabViewId, id);}
function tabview_initialize(TabViewId, currentTab) {tabview_aux(TabViewId,  currentTab);}

//End Functions to manipulate tabs view




// ***** ListItemPage1 **************************************************************

//Start function to set the page height
//function setPageHeight()
//{
//        var content = document.getElementById("content");
//        content.style.height = '';
//}
//End function to set the page height


// ***** ListItemPage1 **************************************************************


// ***** ListItemPage2 **************************************************************
//Functions to do the ajax upload image:
function $m(theVar){
	return document.getElementById(theVar)
}
function remove(theVar){
	var theParent = theVar.parentNode;
	theParent.removeChild(theVar);
}
function addEvent(obj, evType, fn){
	if(obj.addEventListener)
	    obj.addEventListener(evType, fn, true)
	if(obj.attachEvent)
	    obj.attachEvent("on"+evType, fn)
}
function removeEvent(obj, type, fn){
	if(obj.detachEvent){
		obj.detachEvent('on'+type, fn);
	}else{
		obj.removeEventListener(type, fn, false);
	}
}
function isWebKit(){
	return RegExp(" AppleWebKit/").test(navigator.userAgent);
}
function ajaxUploadImage(form,uploadType,url_action,id_element,html_show_loading,html_error_http){

	var detectWebKit = isWebKit();
	form = typeof(form)=="string"?$m(form):form;
	var erro="";

	if(form==null || typeof(form)=="undefined"){
		erro += "The form of 1st parameter does not exists.\n";
	}else if(form.nodeName.toLowerCase()!="form"){
		erro += "The form of 1st parameter its not a form.\n";
	}
	if($m(id_element)==null){
		erro += "The element of 3rd parameter does not exists.\n";
	}
	if(erro.length>0){
		alert("Error in call ajaxUpload:\n" + erro);
		return;
	}
	var iframe = document.createElement("iframe");
	iframe.setAttribute("id","ajax-temp");
	iframe.setAttribute("name","ajax-temp");
	iframe.setAttribute("width","0");
	iframe.setAttribute("height","0");
	iframe.setAttribute("border","0");
	iframe.setAttribute("style","width: 0; height: 0; border: none;");
	form.parentNode.appendChild(iframe);
	window.frames['ajax-temp'].name="ajax-temp";
	var doUpload = function(){
		removeEvent($m('ajax-temp'),"load", doUpload);
		var cross = "javascript: ";
		cross += "window.parent.$m('"+id_element+"').innerHTML = document.body.innerHTML; void(0);";
		$m(id_element).innerHTML = html_error_http;
		$m('ajax-temp').src = cross;
		if(detectWebKit){
        	remove($m('ajax-temp'));
        }else{
        	setTimeout(function(){remove($m('ajax-temp'))}, 250);
        }
    }
//
//        if(uploadType == "image")
//        {
            //set the uploaded list of images
            //and create the string to display the small pic panels while loading
            var uploadedList = "";
            var uploadedListInput = document.getElementById("uploadedList");
            panelsLoading = "<ul id='smallListingPics'>";
            //check the list of 6 panels
            for(x = 1; x < 7; x++)
            {
                var smallPic = document.getElementById("smallPic" + x);
                //if there is a picture in the panel, append it to the uploadedList string to submit
                //as well as the panelsLoading string to display when loading the picture
                if(smallPic.src != (projectPath + "webImages/smallPicBG.jpg"))
                {

                    uploadedList = uploadedList + smallPic.src + "|";
                     panelsLoading += "<li><img src='" + smallPic.src + "' " + "style='width: " + smallPic.width + "px; height:"+
                         smallPic.height + "px; margin-top: "+ smallPic.style.marginTop + ";' class='smallPic' alt='smallPic'/></li>";

                }
                else
                {
                     panelsLoading += "<li><img src='" + projectPath + "webImages/smallPicBG.jpg'  style='width: 41px; height: 44px;' class='smallPic' alt='smallPic'/></li>";
                }
            }

            uploadedListInput.value = uploadedList;
            panelsLoading += "</ul>";
//        }

	addEvent($m('ajax-temp'),"load", doUpload);
	form.setAttribute("target","ajax-temp");
	form.setAttribute("action",url_action);
	form.setAttribute("method","post");
	form.setAttribute("enctype","multipart/form-data");
	form.setAttribute("encoding","multipart/form-data");


	if(html_show_loading.length > 0)
        {
//                if(uploadType == "image")
//                {
                    $m(id_element).innerHTML = "<div id='bigPictureBox' >" + html_show_loading + "</div>" + panelsLoading;
//                }
//                else if(uploadType == "video")
//                {
//                    $m(id_element).innerHTML = html_show_loading;
//
//                }

//                document.getElementById("addFileButton").style.display = 'none';
	}

	form.submit();

        var addImageButton = document.getElementById('addImageButton');
        addImageButton.value = "";

}
//End Functions to do the ajax upload image

//Functions to set the current item picture in listItemPage2
function setBigPicture(picture)
{
        var pictureBox = document.getElementById("bigPictureBox");
        var resizeResolution = document.getElementById("resize_" + picture.id);
        var resolution;
        if(resizeResolution == null)
        {
            resolution = "width='275' height='160'";
        }
        else
        {
            resolution = resizeResolution.value;
        }
        pictureBox.innerHTML = "<img  id='picture' src='"  + picture.src +"' alt='picture' " + resolution + "/>";


}
//End Functions to set the current item picture in listItemPage2

//Functions to remove the item picture in listItemPage2
function removePicture(pictureNumber)
{
        //if the big picture box is currently display the picture we are trying to remove
        //then set another picture to the big picture box
        var smallPic = document.getElementById("smallPic" + pictureNumber);
        var picture = document.getElementById("picture");
        var nextPic;
        if(picture.src == smallPic.src)
        {
            if(pictureNumber > 1)
            {
                setBigPicture(document.getElementById("smallPic1"));
            }
            else
            {
                nextPic = document.getElementById("smallPic" + (pictureNumber + 1));
                setBigPicture(nextPic);
            }
        }
        //if removing last picture then just set the last panel source to smallPicBG image
        //else remove the selected picture by pushing the order of small pic
        for(x = pictureNumber ; x < 7; x++)
        {
            var currentPic = document.getElementById("smallPic" + x);

            var resizeResolution =  document.getElementById("resize_smallPic" + x);

            if(x == 6)
            {
                currentPic.parentNode.innerHTML = "<img id='smallPic" + x + "' style='width: 41px; height: 44px;' class='smallPic' src='" + projectPath +"webImages/smallPicBG.jpg' alt=''/>";
            }
            else
            {
                nextPic = document.getElementById("smallPic" + (x + 1));
                var nextResolution = document.getElementById("resize_smallPic" + (x + 1));

                currentPic.src = nextPic.src;
                if(nextResolution != null)
                {
                    resizeResolution.value = nextResolution.value;
                }
                else
                {
                    //also remove any event that added into the panel
                    currentPic.parentNode.innerHTML = "<img id='smallPic" + x + "' style='width: 41px; height: 44px;' class='smallPic' src='" + projectPath +"webImages/smallPicBG.jpg' alt=''/>";
                }

            }
        }

}
function displayMiniCross(pictureNumber)
{
    var removeButton = document.getElementById("removePictureButton" + pictureNumber);
    removeButton.style.visibility = 'visible';
}

function hideMiniCross(pictureNumber)
{
    var removeButton = document.getElementById("removePictureButton" + pictureNumber);
    removeButton.style.visibility = 'hidden';
}

//End Functions to remove the item picture in listItemPage2

//functions to upload video in listItemPage2
function ajaxUploadVideo(fileName)
{

    //starting setting some animation when the ajax starts and completes
    $("#loading")
    .ajaxStart(function(){
        $(this).show();
    })
    .ajaxComplete(function(){
        $(this).hide();
    });

    /*
        prepareing ajax file upload
        url: the url of script file handling the uploaded files
                    fileElementId: the file type of input element id and it will be the index of  $_FILES Array()
        dataType: it support json, xml
        secureuri:use secure protocol
        success: call back function when the ajax complete
        error: callback function when the ajax failed

            */
    $.ajaxFileUpload
    (
        {
            url:'uploadVideo.php',
            secureuri:false,
            fileElementId: fileName,
            dataType: 'json,mp3',
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        alert(data.error);
                    }else
                    {
                        alert(data.msg);
                    }
                }
            },
            error: function (data, status, e)
            {
                alert(e);
            }
        }
    )

    return false;

}
//End functions to upload video in listItemPage2

//Functions for category selection
function getSubCategory()
{

    var categorySelectBox = document.getElementById("categoryList");
    var category = categorySelectBox.options[categorySelectBox.selectedIndex].value;

    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    categorySelectBox.style.display = 'none';
    document.getElementById('categorySelection').innerHTML= "<label style='color: blue;'> " + category + " >> <img src='" + projectPath +"webImages/working.gif' alt='Loading...'/> ";

    xmlhttp.open("GET",projectPath + "sell/displaySubCategoryList.php?category=" + escape(category),false);

    xmlhttp.send(null);

    document.getElementById('categorySelection').innerHTML=xmlhttp.responseText;

}

function returnCategoryList()
{

    document.getElementById('categorySelection').innerHTML= "";
    var categorySelectBox = document.getElementById("categoryList");
    categorySelectBox.style.display = "";
    var itemCategoryID = document.getElementById("itemCategoryID");
    itemCategoryID.value = "";
    var itemCategory = document.getElementById("itemCategory");
    itemCategory.value = "";
}

function getSubSubCategory()
{
    var subCategorySelectBox = document.getElementById("subCategory");
//    var category = document.getElementById('currentCategory').value;
    var subCategory = subCategorySelectBox.options[subCategorySelectBox.selectedIndex].innerHTML;
    var subID = subCategorySelectBox.options[subCategorySelectBox.selectedIndex].value;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    subCategorySelectBox.style.display = 'none';
    document.getElementById('subCategorySelection').innerHTML= "<label style='color: blue;'> " + subCategory + " >> <img src='" + projectPath + "webImages/working.gif' alt='Loading...'/>";

    xmlhttp.open("GET",projectPath + "sell/displaySubCategoryList.php?subID=" + subID + "&subCategory=" + escape(subCategory),false);

    xmlhttp.send(null);

    document.getElementById('subCategorySelection').innerHTML=xmlhttp.responseText;
    if(document.getElementById('subSubCategory') == null)
    {
        setItemCategory(subCategorySelectBox, 'sub');
    }
}

function returnSubCategoryList()
{
    document.getElementById('subCategorySelection').innerHTML= "";
    var subCategorySelectBox = document.getElementById("subCategory");
    subCategorySelectBox.style.display = "";
    var itemCategoryID = document.getElementById("itemCategoryID");
    itemCategoryID.value = "";
    var itemCategory = document.getElementById("itemCategory");
    itemCategory.value = "";
}

function getSubSubSubCategory()
{
    var subSubCategorySelectBox = document.getElementById("subSubCategory");
//    var category = document.getElementById('currentCategory').value;
    var subSubCategory = subSubCategorySelectBox.options[subSubCategorySelectBox.selectedIndex].innerHTML;
    var subID = subSubCategorySelectBox.options[subSubCategorySelectBox.selectedIndex].value;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    subSubCategorySelectBox.style.display = 'none';
    document.getElementById('subSubCategorySelection').innerHTML= "<label style='color: blue;'> " + subSubCategory + " >> <img src='" + projectPath +"webImages/working.gif' alt='Loading...'/>";

    xmlhttp.open("GET",projectPath + "sell/displaySubCategoryList.php?subID=" + subID + "&subSubCategory=" + escape(subSubCategory),false);

    xmlhttp.send(null);

    document.getElementById('subSubCategorySelection').innerHTML=xmlhttp.responseText;
//    alert(document.getElementById('subSubSubCategory'));

    if(document.getElementById('subSubSubCategory') == null)
    {

        setItemCategory(subSubCategorySelectBox, 'subSub');
    }

}

function returnSubSubCategoryList()
{
    document.getElementById('subSubCategorySelection').innerHTML= "";
    var subSubCategorySelectBox = document.getElementById("subSubCategory");
    subSubCategorySelectBox.style.display = "";
    var itemCategoryID = document.getElementById("itemCategoryID");
    itemCategoryID.value = "";
    var itemCategory = document.getElementById("itemCategory");
    itemCategory.value = "";
}

function returnSubSubSubCategoryList()
{
    document.getElementById('subSubSubCategorySelection').innerHTML= "";
    var subSubCategorySelectBox = document.getElementById("subSubSubCategory");
    subSubCategorySelectBox.style.display = "";
    var itemCategoryID = document.getElementById("itemCategoryID");
    itemCategoryID.value = "";
    var itemCategory = document.getElementById("itemCategory");
    itemCategory.value = "";
}

function setItemCategory(selectedBox, type)
{
    //set the category for item here
    var category = selectedBox.options[selectedBox.selectedIndex].innerHTML;
    var id = selectedBox.options[selectedBox.selectedIndex].value;
    selectedBox.style.display = 'none';

    //set the inputs for category to post to the server when the form is submitted
    var itemCategory = document.getElementById("itemCategory");
    itemCategory.value = category;
    var itemCategoryID = document.getElementById("itemCategoryID");
    itemCategoryID.value =id;
    var categoryType = document.getElementById("categoryType");
    categoryType.value = type;
//depend on what category layer the user is setting, change the hTML content and display the category selected message
    if(document.getElementById('subSubSubCategorySelection') != null)
    {

        document.getElementById('subSubSubCategorySelection').innerHTML = "<div style='position: relative; left: 0px; width: 100px; margin-bottom:5px; font-size: 12px; font-weight: bold;'><a href='javascript:returnSubSubSubCategoryList();' > " + category + "</a> &nbsp&nbsp>>&nbsp</div><label style='color:blue; font-size: 12px;'> Category Selected!</label>";
    }
    else if(document.getElementById("subSubCategorySelection") != null)
    {
        document.getElementById('subSubCategorySelection').innerHTML = "<div style='position: relative; left: 0px; width: 100px; margin-bottom:5px; font-size: 12px; font-weight: bold;'><a href='javascript:returnSubSubCategoryList();' >" + category + "</a>  &nbsp&nbsp>>&nbsp </div><label style='color:blue; font-size: 12px;'> Category Selected!</label>";
    }
    else
    {
        document.getElementById('subCategorySelection').innerHTML = "<div style='margin-bottom:5px; font-size: 12px; font-weight: bold;'><a href='javascript:returnSubCategoryList();' > " + category + "</a>  &nbsp&nbsp>>&nbsp </div><label style='color:blue; font-size: 12px;'> Category Selected!</label>";
    }
}
//
//function returnSubSubCategoryList()
//{
//    document.getElementById('subSubCategorySelection').innerHTML= "";
//    var itemCategory = document.getElementById("itemCategory");
//    itemCategory.value = "";
//    var subSubCategorySelectBox = document.getElementById("subSubCategory");
//    subSubCategorySelectBox.style.display = "";
//}

//End Functions  for category selection



//Functions to remove the item video in listItemPage2
function removeVideo()
{
    //remove everything inside videoBox;
    var videoBox = document.getElementById("bigVideoBox");
    videoBox.innerHTML = '';

}

function displayQuantity()
{
    var buyPrice = document.getElementById("buyPrice").value;
    var bidPrice = document.getElementById("bidPrice").value;
    var qtyLabel = document.getElementById("qtyLabel");
    var qtyInput = document.getElementById("quantity");
    if(buyPrice != "" && bidPrice == "")
    {

        qtyLabel.style.visibility = "visible";
        qtyInput.style.visibility = 'visible';
    }
    else
    {
        qtyLabel.style.visibility = "hidden";
        qtyInput.style.visibility = "hidden";
    }
}


//Functions to submit the form to list new item
function submitItemListForm(type)
{
    //get all upload picture links and upload video link here
    //set into hidden submit field before post them to the server

    for(x = 1; x < 7; x++)
    {
        var smallPic = document.getElementById("smallPic" + x);
        var linkInput = document.getElementById("pictureLink" + x);
        //if there is a picture in the panel, set it to the hidden field to submit to the server

        if(smallPic.src != (projectPath + "webImages/smallPicBG.jpg"))
        {
            //just sent the relative path to the server
            var relLink = smallPic.src.replace(projectPath,"");
            linkInput.value = relLink;
        }
    }

    var videoInput = document.getElementById("videoLink");
    var videoLink = document.getElementById("uploadedVideo");
    if(videoLink != null)
    {
        videoInput.value = videoLink.value;
    }

    //set the type of the form, either 'save' or 'save and continue'
    var typeInput = document.getElementById("submitType");
    typeInput.value = type;

    //check all field correct before submit form, if error input display error message
    var itemTitle = document.getElementById("itemTitle").value;
    var catchPhrase = document.getElementById("catchPhrase").value;
    var itemCategory = document.getElementById("itemCategory");
    var quantity;

    if(document.getElementById("quantity") != null)
    {
        quantity = document.getElementById("quantity").value;
    }
    else
    {
        quantity = 1;
    }

//    var itemDesc = document.getElementByName("itemDesc");
    //remove all comma ',' for price values

    var bidPrice = (document.getElementById("bidPrice").value).replace(',',"");
    var buyPrice = (document.getElementById("buyPrice").value).replace(',',"");
    var itemPostage = document.getElementById("itemPostage");
    var itemCondition = document.getElementById("itemCondition").value;
    var postagePrice = (document.getElementById("postagePrice").value).replace(',',"");
    var form = document.getElementById("listItemForm");

    //check if the user have select at least 1 method
    var paymentMethods = document.getElementsByName("paymentMethod[]");
    var hasPayment = false;
    for(var i=0; i < paymentMethods.length; i ++)
    {

        if(paymentMethods[i].checked)
        {
            hasPayment = true;
        }
    }
//    alert(hasPayment);
//    alert((bidPrice != "" && !isPositiveNumeric(bidPrice)) || (buyPrice != "" && !isPositiveNumeric(buyPrice)));
//    alert(itemTitle == "" || catchPhrase == "" || itemCondition == "");
    var message = document.getElementById("message");

    linkInput = document.getElementById("pictureLink1").value;
    //set up a message list
//    ArrayList messageList = new ArrayList();

    if(itemTitle == "" || catchPhrase == "" || itemCondition == "")
    {
        message.innerHTML = "--> Please fill in Item Title, Catchy Phrase and Item Condition.";
//        messageList.add("Please fill in Item Title, Catchy Phrase, Prices and Item Condition.");
    }
    else if(itemCategory.value == "")
    {
        message.innerHTML = "--> Please choose a Category for your item.";
    }        //check for price input format
    else if(bidPrice == "" && buyPrice == "")
    {
        message.innerHTML = "--> Please fill in either starting bid price or buy now price or both.";
    }
    else if((bidPrice != "" && !isPositiveNumeric(bidPrice)) || (buyPrice != "" && !isPositiveNumeric(buyPrice)))
    {
        message.innerHTML = "--> Item prices need to be in positive numeric format.";
    }
    else if(!isPositiveNumeric(quantity))
    {
        message.innerHTML = "--> Item quantity need to be in positive numeric format.";
    }
    else if(quantity == "" || quantity < 1)
    {
        message.innerHTML = "--> Item quantity need to be at least 1.";
    }
    else if(itemPostage.options[itemPostage.selectedIndex].value == 'Fixed Price' && !isPositiveNumeric(postagePrice))
    {

        message.innerHTML =  "--> Postage fixed price need to be filled in numeric format.";
    }
    else if(linkInput == "" )
    {
        message.innerHTML = "--> Please upload at least 1 picture image of your item.";
    }
    else if(!hasPayment)
    {
        message.innerHTML = "--> Please select at least one payment method.";
    }
    else
    {

        //re-set the price, now with coma removed.
        document.getElementById("bidPrice").value = bidPrice;
        document.getElementById("buyPrice").value = buyPrice;
        document.getElementById("postagePrice").value = postagePrice;


        form.submit();
    }
}

function isPositiveNumeric(strNum)
{

        var NumberofDigitsAfterDecimal =  2 ;
	if (strNum == null || strNum == "")
	{
		return false;
	}

//       check the case of decimal number
        if(strNum.indexOf('.') > -1)
        {
            digitNum = strNum.substring(strNum.indexOf('.') + 1);
            intNum = strNum.substring(0, strNum.indexOf('.'));

             if(digitNum.length > NumberofDigitsAfterDecimal)
             {
                 return false;
             }
             else if(isNaN(digitNum) || isNaN(intNum))
             {

                return false;
             }
             else
             {
                return true;
             }
        }
        //       check the case of integer
        else
        {

            for (var i = 0; i < strNum.length; i++)
            {
                var ch = strNum.charAt(i)
                if (i == 0 && ch == "-")
                {
                    continue
                }
                if (ch < "0" || ch > "9")
                {
                    return false
                }
            }
            return true
        }

}


//End Functions to submit the form to list new item

//End Functions to remove the item picture in listItemPage2

//Functions to show/hide the postage price file in listItemPage2
function displayPostagePrice(postage)
{
        var priceField = document.getElementById("postagePrice");
        var priceLabel = document.getElementById("postagePriceLabel");
        if(postage == "Fixed Price")
        {

            priceField.style.visibility = 'visible';
            priceLabel.style.visibility = 'visible';
        }
        else
        {
            priceField.style.visibility = 'hidden';
            priceLabel.style.visibility = 'hidden';
        }

}

// End Functions to show/hide the postage price file in listItemPage2

// ***** ListItemPage2 **************************************************************

// ***** DisplayItemDetail**************************************************************
//Function to show/hide removeItem button in displayItemDetail page
//function displayEnlargePic()
//{
//    var pic = document.getElementById("itemPicture");
//
//    pic.style.width="685px";
//
//    pic.style.height="595px";
//    pic.style.zIndex= "3";
//    pic.style.position = "absolute";
//    pic.style.top = "67px";
//    pic.style.left = "20px";
//
//}
//
//function displayNormalPic()
//{
//    var pic = document.getElementById("itemPicture");
//
//    if(pic.style.width != "325px")
//    {
//        pic.style.width="325px";
//        pic.style.height="200px";
//        pic.style.position = "relative";
//        pic.style.top = "0px";
//        pic.style.left = "0px";
//        pic.style.zIndex= "1";
//    }
//
//}

function submitComment()
{
      var comment = document.getElementById("comment");

      if(comment.value != "" && comment.value != "Write your comment here")
      {
          document.getElementById("commentForm").submit();
      }

}

//function submitComment(ItemID, UserID)
//{
//      var comment = document.getElementById("comment");
//
//      if(comment.value != "" & comment.value != "Write your comment here")
//      {
////          document.getElementById("commentForm").submit();
//
//        if (window.XMLHttpRequest)
//        {// code for IE7+, Firefox, Chrome, Opera, Safari
//            xmlhttp=new XMLHttpRequest();
//        }
//        else
//        {// code for IE6, IE5
//            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
//        }
//
//        var url = "insertItemComment.php";
//        var params = "UserID=" + UserID + "&ItemID=" + ItemID;
//
//        xmlhttp.open("POST", url, true);
//
//        //Send the proper header information along with the request
//        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//        xmlhttp.setRequestHeader("Content-length", params.length);
//        xmlhttp.setRequestHeader("Connection", "close");
//
//        xmlhttp.onreadystatechange = function() {//Call a function when the state changes.
//                if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//                        document.getElementById("commentBox").innerHTML = xmlhttp.responseText;
//                }
//        }
//        xmlhttp.send(params);
//      }
//
//}

function displayBigPic(picNo)
{
        var picBox = document.getElementById("itemPicture");
        var picture = document.getElementById("picture");
        var picMode = document.getElementById("picMode");

        if(picMode.value == "big")
        {
            //modify picture Box
            picBox.style.width="325px";
            picBox.style.height="200px";
            picBox.style.position = "relative";
            picBox.style.top = "0px";
            picBox.style.left = "0px";
            picBox.style.zIndex= "1";

            //modify picture

            var resolution = document.getElementById("resize_smallPic" + picNo).value;

            picBox.innerHTML = "<input type='hidden' id='picMode' value='small' /><img  id='picture' src='" + picture.src +"' alt='picture' " + resolution + " onClick='displayBigPic(" + picNo +")'/>";
        }
        else
        {
//            if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) //test for Firefox/x.x or Firefox x.x (ignoring remaining digits);
//            {
//                picBox.style.width="680px";
//            }
//            else
            if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) //test for MSIE x.x;
            {
                picBox.style.width="690px";
                picBox.style.height="600px";
            }
            else
            {
                picBox.style.width="682px";
                picBox.style.height="595px";
            }


//            picBox.style.height="595px";
            picBox.style.zIndex= "3";
            picBox.style.position = "absolute";
            picBox.style.top = "86px";
            picBox.style.left = "19px";

            //modify picture
            var bigResolution = document.getElementById("resizeBig_smallPic" + picNo).value;

            picBox.innerHTML = "<input type='hidden' id='picMode' value='big' /><img  id='picture' src='" +  picture.src +"' alt='picture' " + bigResolution + " onClick='displayBigPic(" + picNo +")'/>";

        }
}




function displayRemoveButton(id)
{
        var button = document.getElementById("removeItemButton" + id);
        button.style.visibility='visible';
}


function hideRemoveButton(id)
{
        var button = document.getElementById("removeItemButton" + id);
        button.style.visibility='hidden';
}

//End Function to show/hide removeItem button displayItemDetail page

//Functions to set the current item picture in displayItemDetail page
function setItemPicture(picNo)
{
        var picture = document.getElementById("smallPic" + picNo);
        var pictureBox = document.getElementById("itemPicture");

        var resizeResolution = document.getElementById("resize_" + picture.id);
        var resolution;
        if(resizeResolution == null)
        {
            resolution = "width='325' height='200'";
        }
        else
        {
            resolution = resizeResolution.value;
        }
//        <img id="picture" src="<?php echo $pictureList[0];?>" alt="pictureLink" <?php echo imageResize($imageSize[0],$imageSize[1],  200, 325);?>
//                                                 onClick="displayNormalPic();" style="cursor:url('webImages/imagezoomglass.png')"/>


        pictureBox.innerHTML = "<input type='hidden' id='picMode' value='small' /><img  id='picture' src='" + picture.src +"' alt='picture' " + resolution + " onClick='displayBigPic(" + picNo +")'/>";

}
//End Functions to set the current item picture in displayItemDetail page



//Functions to display a countdown clock from the specified time
var timer;

 function countdown_clock(timeFinish, now)
 {

     html_code = "<label id='countdown' style='color:red;'></label>";

     document.write(html_code);

     countdown(timeFinish, now);
 }
function countdown(timeFinish, now)
{



     //Find the different between the finished time and the current time
     //noted that the getTime() method return miliseconds while the timeFinish is in seconds format
     //thus we have to divided getTime() return with 1000 before finding the difference.
     Time_Left = Math.round(timeFinish - now);


     if(Time_Left <= 0)
     {
        if(document.getElementById("highestBidder") != null)
        {
            document.getElementById("fireWork").style.display = "";
            setTimeout('closeFireWork()', 4000);
        }

        document.getElementById("countdown").innerHTML = 'Ended.';
        clearTimeout(timer);


     }
     else
     {
        //Get format time
        hours = Math.floor(Time_Left / (60 * 60));
        if(hours < 10)
        {
            hours = "0" + hours;
        }
        Time_Left %= (60 * 60);
        minutes = Math.floor(Time_Left / 60);
        if(minutes < 10)
        {
            minutes = "0" + minutes;
        }
        Time_Left %= 60;
        seconds = Time_Left;
        if(seconds < 10)
        {
            seconds = "0" + seconds;
        }

        document.getElementById("countdown").innerHTML ="<b>" + hours + " : " + minutes + " : " + seconds + "</b>";
        document.getElementById("countdown").style.fontSize = '14px';
         //Recursive call, keeps the clock ticking.
         //add one second to the current time
        timer = setTimeout('countdown(' + timeFinish + "," + (now + 1) + ');', 1000);

     }


}

function closeFireWork()
{

    document.getElementById("fireWork").style.display = "none";
}


//End Functions to display a countdown clock from the specified time

//Function to go to confirm purchase page
function goToConfirmPurchase(type, id)
{
    var message = "";

    if(type == 'bid')
    {
        var bidAmount;
        //check if the user is on the item detail page or on a item detail small popup panel
        if(document.getElementById('minBid') == null) // user on the popup panel
        {
            bidAmount = document.getElementById("bidAmount" + id).value;

            if(bidAmount != "")
            {
                window.location = projectPath + "buy/confirmPurchasePage.php?ItemID=" + id + "&type=" + type + "&bidAmount=" + bidAmount;
            }
        }
        else
        {
            bidAmount = document.getElementById("bidAmount").value;
            var minBid = document.getElementById('minBid').value;
            if(bidAmount == "")
            {
                message = "Please enter your bid.";
            }
            else if(!isPositiveNumeric(bidAmount))
            {
                message = "Bid amount must be in positive format.";
            }
            else if(bidAmount < minBid)
            {
                message = "Bid amount must be greater than the minimum allowed bid.";
            }

            window.location = projectPath + "buy/confirmPurchasePage.php?ItemID=" + id + "&type=" + type + "&bidAmount=" + bidAmount + "&message=" + message;
        }

    }
    else
    {
        window.location = projectPath + "buy/confirmPurchasePage.php?ItemID=" + id + "&type=" + type;
    }


}
//End Function to go to confirm purchase page



// ***** DisplayItemDetail**************************************************************

// *****SearchItem**************************************************************

//Functions to set the current item picture in displayItemDetail page
function sortSearchList()
{
    var displaySelect = document.getElementById("displaySelect");
    var sortSelect = document.getElementById("sortSelect");


    //get current display and sort parameter
    var display = displaySelect[displaySelect.selectedIndex].value;

    var sort = sortSelect[sortSelect.selectedIndex].value;

    var currentSearchString = escape(document.getElementById("currentSearchStr").value);
    var currentSearchCategory = escape(document.getElementById("currentSearchCategory").value);
    var currentSellerID = document.getElementById("currentSellerID").value;
    var currentCategoryType = document.getElementById("currentCategoryType").value;
    var currentSubID = document.getElementById("currentSubID").value;

    if(currentSellerID != "")
    {
        window.location = projectPath + "buy/searchProductPage.php?searchSubmit=true&SellerID=" + currentSellerID + "&displayFilter=" + display + "&sortFilter=" + sort;
    }
    else if(currentCategoryType != "")
    {
        window.location = projectPath + "buy/searchProductPage.php?searchSubmit=true&CategoryType=" + currentCategoryType + "&subID=" + currentSubID + "&displayFilter=" + display + "&sortFilter=" + sort;
    }
    else
    {

        window.location = projectPath + "buy/searchProductPage.php?searchSubmit=true&searchString=" + currentSearchString +
            "&searchCategory=" + currentSearchCategory + "&displayFilter=" + display + "&sortFilter=" + sort;
    }
}
//End Functions to set the current item picture in displayItemDetail page


//Function to show/hide item info popup window
function displayInfoPopUp(listName, id, itemContainer)
{
        var popup = document.getElementById(listName + "popUp" + id);
        var CONTAINER_WIDTH = 110;
//        var CONTAINER_HEIGHT = 170;

    //set the popup to be a little bit higher than the item container ( -10px top);
        popup.style.top = (itemContainer.offsetTop - 10)  + "px";
        popup.style.left = (itemContainer.offsetLeft + CONTAINER_WIDTH) + "px";
//        alert(itemContainer.offsetTop + " " + findPosY(itemContainer));
        popup.style.visibility='visible';
}

function reservePopUp(popUp)
{
        popUp.style.visibility='visible';
}



function hideInfoPopUp(id, listName)
{
        var popup = document.getElementById(listName + "popUp" + id);
        popup.style.visibility='hidden';
}

//End Function to show/hide item infor popup window
//
// *****SearchItem**************************************************************

// *****MyAccount**************************************************************

//Functions to display/hide the change password form
function displayChangePasswordForm()
{
    var changePassword = document.getElementById("changePasswordForm");
    var updatePassword = document.getElementById("updatePassword");


    if(changePassword.style.display == "none")
    {
        //display change Password form
        changePassword.style.display = "";
        updatePassword.value = "true";
    }
    else
    {
        changePassword.style.display = "none";
        updatePassword.value = "";
    }
}


//End to display/hide the change password form


//Functions to check all check box in Mail Box
checked=false;

function setAllCheckBox(form)
{
//    var form= document.getElementById('frm1');
	 if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
	for (var i =0; i < form.elements.length; i++)
	{
	 form.elements[i].checked = checked;
	}
}
//End Functions to check all check box in Mail Box
//
//
//Functions to submit delete all message form
function submitDeleteAllMesg(form)
{
    var deleteAll = document.getElementById('deleteAllMesg');
    deleteAll.value = 'true';
    form.submit();
}


//End Functions  to submit delete all message form

//Functions to set the message flag in Mail page
function setMessageFlag(mesgID)
{
    //set the flag on or off;
    var flag = document.getElementById("mesgFlag" + mesgID);
    var flagStatus;
    if(flag.src == (projectPath + "webImages/iconFlagOn.png"))
    {
        flag.src = projectPath + "webImages/iconFlagOff.png";
        flagStatus = 0;
    }
    else
    {
        flag.src = projectPath + "webImages/iconFlagOn.png";
        flagStatus = 1;
    }
    //set the flagged status of the message in the DB""
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.open("GET",projectPath + "account/setMesgFlag.php?mesgID=" + mesgID + "&flagStatus=" + flagStatus,false);

    xmlhttp.send(null);
//    document.getElementById(''test).innerHTML=xmlhttp.responseText;

}
//End Functions  to set the message flag in Mail page

//Function to clear the resolve form
function clearResolveForm()
{
    var caseText = document.getElementById("caseText");
    var itemNumber = document.getElementById("itemNumberInput");
    itemNumber.value = "";
    caseText.value ="";

}
//End function to clear the resolve form

//Function to clear the resolve form
function submitResolveForm(form)
{
    var caseText = document.getElementById("caseText");
    var itemNumber = document.getElementById("itemNumberInput");
    var buyerRadio = document.getElementById("buyerRadio");
    var sellerRadio = document.getElementById("sellerRadio");
    var warningWindow = document.getElementById("resolveWarningWindow");
//    alert(!isNaN(itemNumber.value));
    if(buyerRadio.checked == false && sellerRadio.checked == false)
    {
        warningWindow.innerHTML = "Please indicate you are a buyer or a seller."

    }
    else if((caseText.value == "") || (itemNumber.value == ""))
    {
        warningWindow.innerHTML = "Please input the concerning item number and describe the situation."
    }
    else if((itemNumber.value != "") && isNaN(itemNumber.value))
    {
        warningWindow.innerHTML = "Invalid item number."
    }
    else
    {
        form.submit();
    }
}

//End function to clear the resolve form

//Function to enable the choose a item button in resolution centre
function enableItemChooserButton()
{
    var chooseButton = document.getElementById("chooseItemButton");
    chooseButton.disabled = false;
}

//End Function to enable the choose a item button in resolution centre

//Function to display and close the item chooser window in resolution centre
function displayItemChooser()
{
    var buyerSelect = document.getElementById("buyerRadio");
    if(buyerSelect.checked)
    {
        var buyerItemChooser = document.getElementById("buyerItemChooser");
        buyerItemChooser.style.visibility = 'visible';
    }
    else
    {
        var sellerItemChooser = document.getElementById("sellerItemChooser");
        sellerItemChooser.style.visibility = 'visible';
    }

}

function closeItemChooser(type)
{
    if(type=='buyer')
    {
        var buyerItemChooser = document.getElementById("buyerItemChooser");
        buyerItemChooser.style.visibility = 'hidden';
    }
    else
    {
        var sellerItemChooser = document.getElementById("sellerItemChooser");
        sellerItemChooser.style.visibility = 'hidden';
    }
}
//End Function to display and close  the item chooser window in resolution centre

//Function to set the chosen ItemID into the concern item number field

function setCurrentItemID(id, type)
{

    var currentID = document.getElementById(type +'CurrentItemID');
    currentID.value = id;
    var selectButton = document.getElementsByName(type + "SelectButton");
//    alert(selectButton[0]);
    selectButton[0].style.display = "";

}

function selectItem(type)
{
    var currentID = document.getElementById(type +'CurrentItemID');
    var itemNumber = document.getElementById("itemNumberInput");
    itemNumber.value = currentID.value;

    if(type=='buyer')
    {
        var buyerItemChooser = document.getElementById("buyerItemChooser");
        buyerItemChooser.style.visibility = 'hidden';
    }
    else
    {
        var sellerItemChooser = document.getElementById("sellerItemChooser");
        sellerItemChooser.style.visibility = 'hidden';
    }
}

//End Function to set the chosen ItemID into the concern item number field

//Function to set the chosen ItemID into the concern item number field
function displayFeedBackWindow(id)
{
    var feedbackWindow = document.getElementById("feedBackWindow"+id);
    feedbackWindow.style.visibility = 'visible';
//    alert(feedbackWindow);
}
//End Function to set the chosen ItemID into the concern item number field

//Function to set the chosen ItemID into the concern item number field
function submitFeedback(form)
{
//    alert("here");
    var reason = document.getElementById("reasonInput");
    var warningPanel = document.getElementById("feedbackWarningWindow");

    if(reason.value == "")
    {

        warningPanel.innerHTML = "Please fill in the reason for your rating before submit."
    }
    else
    {

        form.submit();
    }

}
//End Function to set the chosen ItemID into the concern item number field
// *****MyAccount**************************************************************


// *****ViewUserProfilePage**************************************************************
function clearMessageForm()
{
    var subjectInput = document.getElementById("subjectInput");
    var mesgContent = document.getElementById("mesgContent");
    subjectInput.value = "";
    mesgContent.value = "";

}

function submitMessageForm(form)
{

    var subjectInput = document.getElementById("subjectInput");
    var mesgContent = document.getElementById("mesgContent");
    var warningPanel = document.getElementById("warningPanel");

    if(subjectInput.value == "" || mesgContent.value == "")
    {
        warningPanel.innerHTML = "Please ensure that both subject and message content are filled."
    }
    else
    {
        form.submit();
    }

}
// *****ViewUserProfilePage**************************************************************

// *****browseCategoryPage**************************************************************

//Function to display the next sub category list
var currentNav1 = "";

function displayNextList(type, id, obj)
{
    //reset bg color of previous current nav
    if(currentNav1 != "")
    {
        currentNav1.style.fontWeight = 'normal';
    }


//     var list = document.getElementById(type + "List");

//     for($count =0; $count < list.childNodes.length; $count++)
//     {
//        var node = list.childNodes[$count];
//        if(node.nodeName=="LI")
//        {
//            node.style.backgroundColor = 'transparent';
//
//        }
//     }




    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    if(type != "showItem")
    {
        xmlhttp.open("GET",projectPath + "buy/getNextSubCategoryList.php?type=" + type + "&subID=" + id,false);

        xmlhttp.send(null);

        if(type== 'subSub')
        {
            document.getElementById("subCategoryID").value = id;

            if(obj != null)
            {
                var subCategoryName = obj.innerHTML;
            }
            else
            {
                var subCategoryName = document.getElementById("subCategoryName").value;
            }

            document.getElementById("subCategoryName").value = subCategoryName;

            document.getElementById("bigHeading").innerHTML = "<a href='' style='cursor:pointer; font-size: 16px;' onclick='backToPreviousList(" + type +")'>" +
                document.getElementById("categoryName").value + "</a>" + " >> " + subCategoryName;



        }
        else if(type == 'subSubSub')
        {
            if(obj != null)
            {
                var subSubCategoryName = obj.innerHTML;
            }
            else
            {
                var subSubCategoryName = document.getElementById("subSubCategoryName").value;
            }

            document.getElementById("subSubCategoryID").value = id;
            document.getElementById("bigHeading").innerHTML = "<a href='' style='cursor:pointer; font-size: 16px;' onclick='backToPreviousList(subSub)'>" +
                document.getElementById("categoryName").value + "</a>" + " >> <a href='' style='cursor:pointer; font-size: 16px;' onclick='backToPreviousList(subSubSub)'>" +
                document.getElementById("subCategoryName").value + "</a>" + " >> " + subSubCategoryName;
        }

        if(xmlhttp.responseText != "")
        {



            document.getElementById("leftPanel").innerHTML=xmlhttp.responseText;

        }
        else
        {
            if(obj != null)
            {
                obj.style.fontWeight= "bold";
                currentNav1 = obj;
            }
        }
    }
    else
    {
        this.style.fontWeigth = "bold";
    }

    xmlhttp.open("GET",projectPath + "buy/getSubCategoryItemList.php?type=" + type + "&subID=" + id,false);

    xmlhttp.send(null);

    document.getElementById("rightPanel").innerHTML=xmlhttp.responseText;

    //check if there is a searchLink set, if there is redirect to the search result page
//    var searchLink = document.getElementById("searchLink");
//    if(searchLink != null)
//    {
//        window.location = searchLink.value;
//    }
}

function backToPreviousList(type)
{
    document.getElementById("bigHeading").innerHTML = document.getElementById("categoryName").value;

    if(type == 'subSub')
    {
        var id = document.getElementById("subCategoryID").value;
        displayNextList(type, id, null);
    }
    else if (type == "subSubSub")
    {
        var id = document.getElementById("subSubCategoryID").value;
        displayNextList(type,  id, null);
    }
}

//End Function to display the next sub category list


// *****browseCategoryPage**************************************************************

// *****paymentPage**************************************************************

//Function to displayt the payment method detail
function displayPaymentMethod(methodName)
{
    //hide every method details
    var detailBox = document.getElementById("paymentDetail");

    for(var count =0; count < detailBox.childNodes.length; count++)
    {
        var node = detailBox.childNodes[count];
        if(node.nodeName=="DIV")
        {
            node.style.display = "none";
        }
    }
//alert(methodName);
//only display the current selected method detail
    var methodDetail;
    var confirmLink = document.getElementById("confirmPaymentLink");
    if(methodName == "Bank Deposit")
    {
        methodDetail = document.getElementById("bankDetail");

        //display the confirmPayment button and hide the button link to Paypal payment page
        confirmLink.style.visibility = "visible";
        document.getElementById("paypalForm").style.visibility = 'hidden';;
    }
    else if(methodName == "PayPal")
    {
        methodDetail = document.getElementById(methodName + "Detail");

        //hide the confirmPayment button and display the button link to Paypal payment page
        confirmLink.style.visibility = 'hidden';
        document.getElementById("paypalForm").style.visibility = "visible";
    }
    else
    {
        methodDetail = document.getElementById("otherMethodDetail");

        //hide the confirmPayment button and display the button link to Paypal payment page
        confirmLink.style.visibility = 'visible';
        document.getElementById("paypalForm").style.visibility = "hidden";
    }

    methodDetail.style.display = "";

//also set the parameter for the confirmPayment link


    confirmLink.href += "&paymentMethod=" + escape(methodName);


    var confirmButton = document.getElementById("confirmPaymentButton");

    confirmButton.style.visibility = "visible";
}

//End Function to displayt the payment method detail
// ***paymentPage**************************************************************


function covertHTMLToString(str)
{
    str = str.replace(/&quot;/g,'"');
    str = str.replace(/&amp;/g,"&");
    str = str.replace(/&lt;/g,"<");
    str =  str.replace(/&gt;/g,">");
    return str;

}


