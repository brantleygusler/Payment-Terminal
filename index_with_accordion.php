<?php

	
	//REQUIRE CONFIGURATION FILE
	require("includes/config.php"); //important file. Don't forget to edit it!
	//DEFAULT PARAMETERS FOR FORM [!DO NOT EDIT!]
	$show_form=1;
	$mess="";
	//REQUEST VARIABLES 
	$item_description = (!empty($_REQUEST["item_description"]))?strip_tags(str_replace("'","`",$_REQUEST["item_description"])):'';
	$amount = (!empty($_REQUEST["amount"]))?strip_tags(str_replace("'","`",$_REQUEST["amount"])):'';
	$fname = (!empty($_REQUEST["fname"]))?strip_tags(str_replace("'","`",$_REQUEST["fname"])):'';
	$lname = (!empty($_REQUEST["lname"]))?strip_tags(str_replace("'","`",$_REQUEST["lname"])):'';
	$email = (!empty($_REQUEST["email"]))?strip_tags(str_replace("'","`",$_REQUEST["email"])):'';
	$address = (!empty($_REQUEST["address"]))?strip_tags(str_replace("'","`",$_REQUEST["address"])):'';
	$city = (!empty($_REQUEST["city"]))?strip_tags(str_replace("'","`",$_REQUEST["city"])):'';
	$country = (!empty($_REQUEST["country"]))?strip_tags(str_replace("'","`",$_REQUEST["country"])):'US';
	$state = (!empty($_REQUEST["state"]))?strip_tags(str_replace("'","`",$_REQUEST["state"])):'';
	$zip = (!empty($_REQUEST["zip"]))?strip_tags(str_replace("'","`",$_REQUEST["zip"])):'';
	$service = (!empty($_REQUEST['service']))?strip_tags(str_replace("'","`",strip_tags($_REQUEST['service']))):'0';
	
	//FORM SUBMISSION PROCESSING 
	if(!empty($_POST["process"]) && $_POST["process"]=="yes"){
		require("includes/form.processing.php");
	}  
	//REQUIRE SITE HEADER TEMPLATE		
	require "includes/site.header.php"; 
?>
<div align="center" class="wrapper">
<?php include "includes/javascript.validation.php"; ?>
  	
    <div class="form_container">
    	<h1>Stripe Payment Terminal</h1>
        <?php echo $mess; ?>
        <form id="ff1" name="ff1" method="post" action="" enctype="multipart/form-data"  onsubmit="return false;"  class="pppt_form">
            <div id="accordion">               
                <?php if($show_form){ ?>
            	<!-- PAYMENT BLOCK -->
                <h2 class="current">Payment Information</h2>
                <div class="pane" style="display:block">
                    <?php if($show_services || $payment_mode=="RECUR"){
                        echo "<label>Service: </label><select name='service' id='service' class='long-field' onchange='checkFieldBack(this)'><option value=''>Please Select</option>";
                        switch($payment_mode){

                        case"ONETIME":
                            //IF services specified in config file - we show services.

                            foreach($services as $k=>$v){
                                echo "<option value='".$k."' ".($service==$k?"selected":"").">".$v[0]." (".(strtolower(AccountCurrency)=="gbp"?"&pound;":(strtolower(AccountCurrency)=="eur"?"&euro;":"$")).number_format($v[1],2).")"."</option>";
                            }
                            echo "</select><div class='clr'></div>";
                        break;
                        case"RECUR":
                            //IF services specified in config file - we show services.

                            foreach($recur_services as $k=>$v){
                                echo "<option value='".$k."' ".($service==$k?"selected":"").">".$v[0]." (".(strtolower(AccountCurrency)=="gbp"?"&pound;":(strtolower(AccountCurrency)=="eur"?"&euro;":"$")).number_format($v[1],2).")"."</option>";
                            }
                            echo "</select><div class='clr'></div>";

                        break;
                        }
                    } else { ?>
                        <label>Description:</label>
                        <input name="item_description" id="item_description" type="text" class="long-field"  value="<?php echo $item_description;?>" onkeyup="checkFieldBack(this);" />
                        <div class="clr"></div>
                        <label>Amount:</label>
                        <input name="amount" id="amount" type="text" class="small-field" value="<?php echo $amount;?>"  onkeyup="checkFieldBack(this);noAlpha(this);" onkeypress="noAlpha(this);" />
                        <div class="clr"></div>
                    <?php } ?>
                </div>
            	<!-- PAYMENT BLOCK -->
            
            
            	<!-- BILLING BLOCK -->
                <h2>Billing Information</h2>
                <div class="pane">
                 	<label>First Name:</label>
                    <input name="fname" id="fname" type="text" class="long-field"  value="<?php echo $fname;?>" onkeyup="checkFieldBack(this);" />
                    <div class="clr"></div>
                    
                     <label>Last Name:</label>
                    <input name="lname" id="lname" type="text" class="long-field"  value="<?php echo $lname;?>" onkeyup="checkFieldBack(this);" />
                    <div class="clr"></div>
                    
                     <label>Address:</label>
                    <input name="address" id="address" type="text" class="long-field"  value="<?php echo $address;?>" onkeyup="checkFieldBack(this);" />
                    <div class="clr"></div>
                    
                     <label>City:</label>
                    <input name="city" id="city" type="text" class="long-field"  value="<?php echo $city;?>" onkeyup="checkFieldBack(this);" />
                    <div class="clr"></div>
                    
                    <label>Country:</label>
                    <select name="country" id="country" class="long-field" onchange="checkFieldBack(this);"> 
                 		<option value="">Please Select</option> 
                 		<option value="US" <?php echo $country=="US"?"selected":""?>>United States</option>
                        <option value="CA" <?php echo $country=="CA"?"selected":""?>>Canada</option>
                        <option value="UK" <?php echo $country=="UK"?"selected":""?>>United Kingdom</option>
						<option value="AU" <?php echo $country=="AU"?"selected":""?>>Australia</option>
						<option value="AF" <?php echo $country=="AF"?"selected":""?>>Afghanistan</option>
                        <option value="AL" <?php echo $country=="AL"?"selected":""?>>Albania</option>
                        <option value="DZ" <?php echo $country=="DZ"?"selected":""?>>Algeria</option>
                        <option value="AS" <?php echo $country=="AS"?"selected":""?>>American Samoa</option>
                        <option value="AD" <?php echo $country=="AD"?"selected":""?>>Andorra</option>
                        <option value="AO" <?php echo $country=="AO"?"selected":""?>>Angola</option>
                        <option value="AI" <?php echo $country=="AI"?"selected":""?>>Anguilla</option>
                        <option value="AQ" <?php echo $country=="AQ"?"selected":""?>>Antarctica</option>
                        <option value="AG" <?php echo $country=="AG"?"selected":""?>>Antigua and Barbuda</option>
                        <option value="AR" <?php echo $country=="AR"?"selected":""?>>Argentina</option>
                        <option value="AM" <?php echo $country=="AM"?"selected":""?>>Armenia</option>
                        <option value="AW" <?php echo $country=="AW"?"selected":""?>>Aruba</option>
                        <option value="AT" <?php echo $country=="AT"?"selected":""?>>Austria</option>
                        <option value="AZ" <?php echo $country=="AZ"?"selected":""?>>Azerbaijan</option>
                        <option value="BS" <?php echo $country=="BS"?"selected":""?>>Bahamas</option>
                        <option value="BH" <?php echo $country=="BH"?"selected":""?>>Bahrain</option>
                        <option value="BD" <?php echo $country=="BD"?"selected":""?>>Bangladesh</option>
                        <option value="BB" <?php echo $country=="BB"?"selected":""?>>Barbados</option>
                        <option value="BY" <?php echo $country=="BY"?"selected":""?>>Belarus</option>
                        <option value="BE" <?php echo $country=="BE"?"selected":""?>>Belgium</option>
                        <option value="BZ" <?php echo $country=="BZ"?"selected":""?>>Belize</option>
                        <option value="BJ" <?php echo $country=="BJ"?"selected":""?>>Benin</option>
                        <option value="BM" <?php echo $country=="BM"?"selected":""?>>Bermuda</option>
                        <option value="BT" <?php echo $country=="BT"?"selected":""?>>Bhutan</option>
                        <option value="BO" <?php echo $country=="BO"?"selected":""?>>Bolivia</option>
                        <option value="BA" <?php echo $country=="BA"?"selected":""?>>Bosnia and Herzegovina</option>
                        <option value="BW" <?php echo $country=="BW"?"selected":""?>>Botswana</option>
                        <option value="BR" <?php echo $country=="BR"?"selected":""?>>Brazil</option>
                        <option value="BN" <?php echo $country=="BN"?"selected":""?>>Brunei Darussalam</option>
                        <option value="BG" <?php echo $country=="BG"?"selected":""?>>Bulgaria</option>
                        <option value="BF" <?php echo $country=="BF"?"selected":""?>>Burkina Faso</option>
                        <option value="BI" <?php echo $country=="BI"?"selected":""?>>Burundi</option>
                        <option value="KH" <?php echo $country=="KH"?"selected":""?>>Cambodia</option>
                        <option value="CM" <?php echo $country=="CM"?"selected":""?>>Cameroon</option>
                        <option value="CV" <?php echo $country=="CV"?"selected":""?>>Cape Verde</option>
                        <option value="KY" <?php echo $country=="KY"?"selected":""?>>Cayman Islands</option>
                        <option value="CF" <?php echo $country=="CF"?"selected":""?>>Central African Republic</option>
                        <option value="TD" <?php echo $country=="TD"?"selected":""?>>Chad</option>
                        <option value="CL" <?php echo $country=="CL"?"selected":""?>>Chile</option>
                        <option value="CN" <?php echo $country=="CN"?"selected":""?>>China</option>
                        <option value="CX" <?php echo $country=="CX"?"selected":""?>>Christmas Island</option>
                        <option value="CC" <?php echo $country=="CC"?"selected":""?>>Cocos (Keeling) Islands</option>
                        <option value="CO" <?php echo $country=="CO"?"selected":""?>>Colombia</option>
                        <option value="KM" <?php echo $country=="KM"?"selected":""?>>Comoros</option>
                        <option value="CG" <?php echo $country=="CG"?"selected":""?>>Congo</option>
                        <option value="CD" <?php echo $country=="CD"?"selected":""?>>Congo, The Democratic Republic of the</option>
                        <option value="CK" <?php echo $country=="CK"?"selected":""?>>Cook Islands</option>
                        <option value="CR" <?php echo $country=="CR"?"selected":""?>>Costa Rica</option>
                        <option value="CI" <?php echo $country=="CI"?"selected":""?>>Cote D`Ivoire</option>
                        <option value="HR" <?php echo $country=="HR"?"selected":""?>>Croatia</option>
                        <option value="CY" <?php echo $country=="CY"?"selected":""?>>Cyprus</option>
                        <option value="CZ" <?php echo $country=="CZ"?"selected":""?>>Czech Republic</option>
                        <option value="DK" <?php echo $country=="DK"?"selected":""?>>Denmark</option>
                        <option value="DJ" <?php echo $country=="DJ"?"selected":""?>>Djibouti</option>
                        <option value="DM" <?php echo $country=="DM"?"selected":""?>>Dominica</option>
                        <option value="DO" <?php echo $country=="DO"?"selected":""?>>Dominican Republic</option>
                        <option value="EC" <?php echo $country=="EC"?"selected":""?>>Ecuador</option>
                        <option value="EG" <?php echo $country=="EG"?"selected":""?>>Egypt</option>
                        <option value="SV" <?php echo $country=="SV"?"selected":""?>>El Salvador</option>
                        <option value="GQ" <?php echo $country=="GQ"?"selected":""?>>Equatorial Guinea</option>
                        <option value="ER" <?php echo $country=="ER"?"selected":""?>>Eritrea</option>
                        <option value="EE" <?php echo $country=="EE"?"selected":""?>>Estonia</option>
                        <option value="ET" <?php echo $country=="ET"?"selected":""?>>Ethiopia</option>
                        <option value="FK" <?php echo $country=="FK"?"selected":""?>>Falkland Islands (Malvinas)</option>
                        <option value="FO" <?php echo $country=="FO"?"selected":""?>>Faroe Islands</option>
                        <option value="FJ" <?php echo $country=="FJ"?"selected":""?>>Fiji</option>
                        <option value="FI" <?php echo $country=="FI"?"selected":""?>>Finland</option>
                        <option value="FR" <?php echo $country=="FR"?"selected":""?>>France</option>
                        <option value="GF" <?php echo $country=="GF"?"selected":""?>>French Guiana</option>
                        <option value="PF" <?php echo $country=="PF"?"selected":""?>>French Polynesia</option>
                        <option value="GA" <?php echo $country=="GA"?"selected":""?>>Gabon</option>
                        <option value="GM" <?php echo $country=="GM"?"selected":""?>>Gambia</option>
                        <option value="GE" <?php echo $country=="GE"?"selected":""?>>Georgia</option>
                        <option value="DE" <?php echo $country=="DE"?"selected":""?>>Germany</option>
                        <option value="GH" <?php echo $country=="GH"?"selected":""?>>Ghana</option>
                        <option value="GI" <?php echo $country=="GI"?"selected":""?>>Gibraltar</option>
                        <option value="GR" <?php echo $country=="GR"?"selected":""?>>Greece</option>
                        <option value="GL" <?php echo $country=="GL"?"selected":""?>>Greenland</option>
                        <option value="GD" <?php echo $country=="GD"?"selected":""?>>Grenada</option>
                        <option value="GP" <?php echo $country=="GP"?"selected":""?>>Guadeloupe</option>
                        <option value="GU" <?php echo $country=="GU"?"selected":""?>>Guam</option>
                        <option value="GT" <?php echo $country=="GT"?"selected":""?>>Guatemala</option>
                        <option value="GN" <?php echo $country=="GN"?"selected":""?>>Guinea</option>
                        <option value="GW" <?php echo $country=="GW"?"selected":""?>>Guinea-Bissau</option>
                        <option value="GY" <?php echo $country=="GY"?"selected":""?>>Guyana</option>
                        <option value="HT" <?php echo $country=="HT"?"selected":""?>>Haiti</option>
                        <option value="HN" <?php echo $country=="HN"?"selected":""?>>Honduras</option>
                        <option value="HK" <?php echo $country=="HK"?"selected":""?>>Hong Kong</option>
                        <option value="HU" <?php echo $country=="HU"?"selected":""?>>Hungary</option>
                        <option value="IS" <?php echo $country=="IS"?"selected":""?>>Iceland</option>
                        <option value="IN" <?php echo $country=="IN"?"selected":""?>>India</option>
                        <option value="ID" <?php echo $country=="ID"?"selected":""?>>Indonesia</option>
                        <option value="IR" <?php echo $country=="IR"?"selected":""?>>Iran (Islamic Republic Of)</option>
                        <option value="IQ" <?php echo $country=="IQ"?"selected":""?>>Iraq</option>
                        <option value="IE" <?php echo $country=="IE"?"selected":""?>>Ireland</option>
                        <option value="IL" <?php echo $country=="IL"?"selected":""?>>Israel</option>
                        <option value="IT" <?php echo $country=="IT"?"selected":""?>>Italy</option>
                        <option value="JM" <?php echo $country=="JM"?"selected":""?>>Jamaica</option>
                        <option value="JP" <?php echo $country=="JP"?"selected":""?>>Japan</option>
                        <option value="JO" <?php echo $country=="JO"?"selected":""?>>Jordan</option>
                        <option value="KZ" <?php echo $country=="KZ"?"selected":""?>>Kazakhstan</option>
                        <option value="KE" <?php echo $country=="KE"?"selected":""?>>Kenya</option>
                        <option value="KI" <?php echo $country=="KI"?"selected":""?>>Kiribati</option>
                        <option value="KP" <?php echo $country=="KP"?"selected":""?>>Korea North</option>
                        <option value="KR" <?php echo $country=="KR"?"selected":""?>>Korea South</option>
                        <option value="KW" <?php echo $country=="KW"?"selected":""?>>Kuwait</option>
                        <option value="KG" <?php echo $country=="KG"?"selected":""?>>Kyrgyzstan</option>
                        <option value="LA" <?php echo $country=="LA"?"selected":""?>>Laos</option>
                        <option value="LV" <?php echo $country=="LV"?"selected":""?>>Latvia</option>
                        <option value="LB" <?php echo $country=="LB"?"selected":""?>>Lebanon</option>
                        <option value="LS" <?php echo $country=="LS"?"selected":""?>>Lesotho</option>
                        <option value="LR" <?php echo $country=="LR"?"selected":""?>>Liberia</option>
                        <option value="LI" <?php echo $country=="LI"?"selected":""?>>Liechtenstein</option>
                        <option value="LT" <?php echo $country=="LT"?"selected":""?>>Lithuania</option>
                        <option value="LU" <?php echo $country=="LU"?"selected":""?>>Luxembourg</option>
                        <option value="MO" <?php echo $country=="MO"?"selected":""?>>Macau</option>
                        <option value="MK" <?php echo $country=="MK"?"selected":""?>>Macedonia</option>
                        <option value="MG" <?php echo $country=="MG"?"selected":""?>>Madagascar</option>
                        <option value="MW" <?php echo $country=="MW"?"selected":""?>>Malawi</option>
                        <option value="MY" <?php echo $country=="MY"?"selected":""?>>Malaysia</option>
                        <option value="MV" <?php echo $country=="MV"?"selected":""?>>Maldives</option>
                        <option value="ML" <?php echo $country=="ML"?"selected":""?>>Mali</option>
                        <option value="MT" <?php echo $country=="MT"?"selected":""?>>Malta</option>
                        <option value="MH" <?php echo $country=="MH"?"selected":""?>>Marshall Islands</option>
                        <option value="MQ" <?php echo $country=="MQ"?"selected":""?>>Martinique</option>
                        <option value="MR" <?php echo $country=="MR"?"selected":""?>>Mauritania</option>
                        <option value="MU" <?php echo $country=="MU"?"selected":""?>>Mauritius</option>
                        <option value="MX" <?php echo $country=="MX"?"selected":""?>>Mexico</option>
                        <option value="FM" <?php echo $country=="FM"?"selected":""?>>Micronesia</option>
                        <option value="MD" <?php echo $country=="MD"?"selected":""?>>Moldova</option>
                        <option value="MC" <?php echo $country=="MC"?"selected":""?>>Monaco</option>
                        <option value="MN" <?php echo $country=="MN"?"selected":""?>>Mongolia</option>
                        <option value="MS" <?php echo $country=="MS"?"selected":""?>>Montserrat</option>
                        <option value="MA" <?php echo $country=="MA"?"selected":""?>>Morocco</option>
                        <option value="MZ" <?php echo $country=="MZ"?"selected":""?>>Mozambique</option>
                        <option value="NA" <?php echo $country=="NA"?"selected":""?>>Namibia</option>
                        <option value="NP" <?php echo $country=="NP"?"selected":""?>>Nepal</option>
                        <option value="NL" <?php echo $country=="NL"?"selected":""?>>Netherlands</option>
                        <option value="AN" <?php echo $country=="AN"?"selected":""?>>Netherlands Antilles</option>
                        <option value="NC" <?php echo $country=="NC"?"selected":""?>>New Caledonia</option>
                        <option value="NZ" <?php echo $country=="NZ"?"selected":""?>>New Zealand</option>
                        <option value="NI" <?php echo $country=="NI"?"selected":""?>>Nicaragua</option>
                        <option value="NE" <?php echo $country=="NE"?"selected":""?>>Niger</option>
                        <option value="NG" <?php echo $country=="NG"?"selected":""?>>Nigeria</option>
                        <option value="NO" <?php echo $country=="NO"?"selected":""?>>Norway</option>
                        <option value="OM" <?php echo $country=="OM"?"selected":""?>>Oman</option>
                        <option value="PK" <?php echo $country=="PK"?"selected":""?>>Pakistan</option>
                        <option value="PW" <?php echo $country=="PW"?"selected":""?>>Palau</option>
                        <option value="PS" <?php echo $country=="PS"?"selected":""?>>Palestine Autonomous</option>
                        <option value="PA" <?php echo $country=="PA"?"selected":""?>>Panama</option>
                        <option value="PG" <?php echo $country=="PG"?"selected":""?>>Papua New Guinea</option>
                        <option value="PY" <?php echo $country=="PY"?"selected":""?>>Paraguay</option>
                        <option value="PE" <?php echo $country=="PE"?"selected":""?>>Peru</option>
                        <option value="PH" <?php echo $country=="PH"?"selected":""?>>Philippines</option>
                        <option value="PL" <?php echo $country=="PL"?"selected":""?>>Poland</option>
                        <option value="PT" <?php echo $country=="PT"?"selected":""?>>Portugal</option>
                        <option value="PR" <?php echo $country=="PR"?"selected":""?>>Puerto Rico</option>
                        <option value="QA" <?php echo $country=="QA"?"selected":""?>>Qatar</option>
                        <option value="RE" <?php echo $country=="RE"?"selected":""?>>Reunion</option>
                        <option value="RO" <?php echo $country=="RO"?"selected":""?>>Romania</option>
                        <option value="RU" <?php echo $country=="RU"?"selected":""?>>Russian Federation</option>
                        <option value="RW" <?php echo $country=="RW"?"selected":""?>>Rwanda</option>
                        <option value="VC" <?php echo $country=="VC"?"selected":""?>>Saint Vincent and the Grenadines</option>
                        <option value="MP" <?php echo $country=="MP"?"selected":""?>>Saipan</option>
                        <option value="SM" <?php echo $country=="SM"?"selected":""?>>San Marino</option>
                        <option value="SA" <?php echo $country=="SA"?"selected":""?>>Saudi Arabia</option>
                        <option value="SN" <?php echo $country=="SN"?"selected":""?>>Senegal</option>
                        <option value="SC" <?php echo $country=="SC"?"selected":""?>>Seychelles</option>
                        <option value="SL" <?php echo $country=="SL"?"selected":""?>>Sierra Leone</option>
                        <option value="SG" <?php echo $country=="SG"?"selected":""?>>Singapore</option>
                        <option value="SK" <?php echo $country=="SK"?"selected":""?>>Slovak Republic</option>
                        <option value="SI" <?php echo $country=="SI"?"selected":""?>>Slovenia</option>
                        <option value="SO" <?php echo $country=="SO"?"selected":""?>>Somalia</option>
                        <option value="ZA" <?php echo $country=="ZA"?"selected":""?>>South Africa</option>
                        <option value="ES" <?php echo $country=="ES"?"selected":""?>>Spain</option>
                        <option value="LK" <?php echo $country=="LK"?"selected":""?>>Sri Lanka</option>
                        <option value="KN" <?php echo $country=="KN"?"selected":""?>>St. Kitts/Nevis</option>
                        <option value="LC" <?php echo $country=="LC"?"selected":""?>>St. Lucia</option>
                        <option value="SD" <?php echo $country=="SD"?"selected":""?>>Sudan</option>
                        <option value="SR" <?php echo $country=="SR"?"selected":""?>>Suriname</option>
                        <option value="SZ" <?php echo $country=="SZ"?"selected":""?>>Swaziland</option>
                        <option value="SE" <?php echo $country=="SE"?"selected":""?>>Sweden</option>
                        <option value="CH" <?php echo $country=="CH"?"selected":""?>>Switzerland</option>
                        <option value="SY" <?php echo $country=="SY"?"selected":""?>>Syria</option>
                        <option value="TW" <?php echo $country=="TW"?"selected":""?>>Taiwan</option>
                        <option value="TI" <?php echo $country=="TI"?"selected":""?>>Tajikistan</option>
                        <option value="TZ" <?php echo $country=="TZ"?"selected":""?>>Tanzania</option>
                        <option value="TH" <?php echo $country=="TH"?"selected":""?>>Thailand</option>
                        <option value="TG" <?php echo $country=="TG"?"selected":""?>>Togo</option>
                        <option value="TK" <?php echo $country=="TK"?"selected":""?>>Tokelau</option>
                        <option value="TO" <?php echo $country=="TO"?"selected":""?>>Tonga</option>
                        <option value="TT" <?php echo $country=="TT"?"selected":""?>>Trinidad and Tobago</option>
                        <option value="TN" <?php echo $country=="TN"?"selected":""?>>Tunisia</option>
                        <option value="TR" <?php echo $country=="TR"?"selected":""?>>Turkey</option>
                        <option value="TM" <?php echo $country=="TM"?"selected":""?>>Turkmenistan</option>
                        <option value="TC" <?php echo $country=="TC"?"selected":""?>>Turks and Caicos Islands</option>
                        <option value="TV" <?php echo $country=="TV"?"selected":""?>>Tuvalu</option>
                        <option value="UG" <?php echo $country=="UG"?"selected":""?>>Uganda</option>
                        <option value="UA" <?php echo $country=="UA"?"selected":""?>>Ukraine</option>
                        <option value="AE" <?php echo $country=="AE"?"selected":""?>>United Arab Emirates</option>
                        <option value="UY" <?php echo $country=="UY"?"selected":""?>>Uruguay</option>
                        <option value="UZ" <?php echo $country=="UZ"?"selected":""?>>Uzbekistan</option>
                        <option value="VU" <?php echo $country=="VU"?"selected":""?>>Vanuatu</option>
                        <option value="VE" <?php echo $country=="VE"?"selected":""?>>Venezuela</option>
                        <option value="VN" <?php echo $country=="VN"?"selected":""?>>Viet Nam</option>
                        <option value="VG" <?php echo $country=="VG"?"selected":""?>>Virgin Islands (British)</option>
                        <option value="VI" <?php echo $country=="VI"?"selected":""?>>Virgin Islands (U.S.)</option>
                        <option value="WF" <?php echo $country=="WF"?"selected":""?>>Wallis and Futuna Islands</option>
                        <option value="YE" <?php echo $country=="YE"?"selected":""?>>Yemen</option>
                        <option value="YU" <?php echo $country=="YU"?"selected":""?>>Yugoslavia</option>
                        <option value="ZM" <?php echo $country=="ZM"?"selected":""?>>Zambia</option>
                        <option value="ZW" <?php echo $country=="ZW"?"selected":""?>>Zimbabwe</option>
                    </select>
                    <div class="clr"></div>
                    
                     <label>State/Province:</label>
                       <select name="state" id="state" class="long-field" onchange="checkFieldBack(this);">
                         <option value="">Please Select</option>
                          <optgroup label="Australian Provinces">
                              <option value="-AU-NSW"  <?php echo $state=="-AU-NSW"?"selected":""?>>New South Wales</option>
                              <option value="-AU-QLD"  <?php echo $state=="-AU-QLD"?"selected":""?>>Queensland</option>
                              <option value="-AU-SA"  <?php echo $state=="-AU-SA"?"selected":""?>>South Australia</option>
                              <option value="-AU-TAS"  <?php echo $state=="-AU-TAS"?"selected":""?>>Tasmania</option>
                              <option value="-AU-VIC"  <?php echo $state=="-AU-VIC"?"selected":""?>>Victoria</option>
                              <option value="-AU-WA"  <?php echo $state=="-AU-WA"?"selected":""?>>Western Australia</option>
                              <option value="-AU-ACT"  <?php echo $state=="-AU-ACT"?"selected":""?>>Australian Capital Territory</option>
                              <option value="-AU-NT"  <?php echo $state=="-AU-NT"?"selected":""?>>Northern Territory</option>
                          </optgroup>
                          <optgroup label="Canadian Provinces">
                              <option value="AB"  <?php echo $state=="AB"?"selected":""?>>Alberta</option>
                              <option value="BC"  <?php echo $state=="BC"?"selected":""?>>British Columbia</option>
                              <option value="MB"  <?php echo $state=="MB"?"selected":""?>>Manitoba</option>
                              <option value="NB"  <?php echo $state=="NB"?"selected":""?>>New Brunswick</option>
                              <option value="NF"  <?php echo $state=="NF"?"selected":""?>>Newfoundland</option>
                              <option value="NT"  <?php echo $state=="NT"?"selected":""?>>Northwest Territories</option>
                              <option value="NS"  <?php echo $state=="NS"?"selected":""?>>Nova Scotia</option>
                              <option value="NVT"  <?php echo $state=="NVT"?"selected":""?>>Nunavut</option>
                              <option value="ON"  <?php echo $state=="ON"?"selected":""?>>Ontario</option>
                              <option value="PE"  <?php echo $state=="PE"?"selected":""?>>Prince Edward Island</option>
                              <option value="QC"  <?php echo $state=="QC"?"selected":""?>>Quebec</option>
                              <option value="SK"  <?php echo $state=="SK"?"selected":""?>>Saskatchewan</option>
                              <option value="YK"  <?php echo $state=="YK"?"selected":""?>>Yukon</option>
                          </optgroup>
                          <optgroup label="US States">
                              <option value="AL"  <?php echo $state=="AL"?"selected":""?>>Alabama</option>
                              <option value="AK"  <?php echo $state=="AK"?"selected":""?>>Alaska</option>
                              <option value="AZ"  <?php echo $state=="AZ"?"selected":""?>>Arizona</option>
                              <option value="AR"  <?php echo $state=="AR"?"selected":""?>>Arkansas</option>
                              <option value="BVI"  <?php echo $state=="BVI"?"selected":""?>>British Virgin Islands</option>
                              <option value="CA"  <?php echo $state=="CA"?"selected":""?>>California</option>
                              <option value="CO"  <?php echo $state=="CO"?"selected":""?>>Colorado</option>
                              <option value="CT"  <?php echo $state=="CT"?"selected":""?>>Connecticut</option>
                              <option value="DE"  <?php echo $state=="DE"?"selected":""?>>Delaware</option>
                              <option value="FL"  <?php echo $state=="FL"?"selected":""?>>Florida</option>
                              <option value="GA"  <?php echo $state=="GA"?"selected":""?>>Georgia</option>
                              <option value="GU"  <?php echo $state=="GU"?"selected":""?>>Guam</option>
                              <option value="HI"  <?php echo $state=="HI"?"selected":""?>>Hawaii</option>
                              <option value="ID"  <?php echo $state=="ID"?"selected":""?>>Idaho</option>
                              <option value="IL"  <?php echo $state=="IL"?"selected":""?>>Illinois</option>
                              <option value="IN"  <?php echo $state=="IN"?"selected":""?>>Indiana</option>
                              <option value="IA"  <?php echo $state=="IA"?"selected":""?>>Iowa</option>
                              <option value="KS"  <?php echo $state=="KS"?"selected":""?>>Kansas</option>
                              <option value="KY"  <?php echo $state=="KY"?"selected":""?>>Kentucky</option>
                              <option value="LA"  <?php echo $state=="LA"?"selected":""?>>Louisiana</option>
                              <option value="ME"  <?php echo $state=="ME"?"selected":""?>>Maine</option>
                              <option value="MP"  <?php echo $state=="MP"?"selected":""?>>Mariana Islands</option>
                              <option value="MPI"  <?php echo $state=="MPI"?"selected":""?>>Mariana Islands (Pacific)</option>
                              <option value="MD"  <?php echo $state=="MD"?"selected":""?>>Maryland</option>
                              <option value="MA"  <?php echo $state=="MA"?"selected":""?>>Massachusetts</option>
                              <option value="MI"  <?php echo $state=="MI"?"selected":""?>>Michigan</option>
                              <option value="MN"  <?php echo $state=="MN"?"selected":""?>>Minnesota</option>
                              <option value="MS"  <?php echo $state=="MS"?"selected":""?>>Mississippi</option>
                              <option value="MO"  <?php echo $state=="MO"?"selected":""?>>Missouri</option>
                              <option value="MT"  <?php echo $state=="MT"?"selected":""?>>Montana</option>
                              <option value="NE"  <?php echo $state=="NE"?"selected":""?>>Nebraska</option>
                              <option value="NV"  <?php echo $state=="NV"?"selected":""?>>Nevada</option>
                              <option value="NH"  <?php echo $state=="NH"?"selected":""?>>New Hampshire</option>
                              <option value="NJ"  <?php echo $state=="NJ"?"selected":""?>>New Jersey</option>
                              <option value="NM"  <?php echo $state=="NM"?"selected":""?>>New Mexico</option>
                              <option value="NY"  <?php echo $state=="NY"?"selected":""?>>New York</option>
                              <option value="NC"  <?php echo $state=="NC"?"selected":""?>>North Carolina</option>
                              <option value="ND"  <?php echo $state=="ND"?"selected":""?>>North Dakota</option>
                              <option value="OH"  <?php echo $state=="OH"?"selected":""?>>Ohio</option>
                              <option value="OK"  <?php echo $state=="OK"?"selected":""?>>Oklahoma</option>
                              <option value="OR"  <?php echo $state=="OR"?"selected":""?>>Oregon</option>
                              <option value="PA"  <?php echo $state=="PA"?"selected":""?>>Pennsylvania</option>
                              <option value="PR"  <?php echo $state=="PR"?"selected":""?>>Puerto Rico</option>
                              <option value="RI"  <?php echo $state=="RI"?"selected":""?>>Rhode Island</option>
                              <option value="SC"  <?php echo $state=="SC"?"selected":""?>>South Carolina</option>
                              <option value="SD"  <?php echo $state=="SD"?"selected":""?>>South Dakota</option>
                              <option value="TN"  <?php echo $state=="TN"?"selected":""?>>Tennessee</option>
                              <option value="TX"  <?php echo $state=="TX"?"selected":""?>>Texas</option>
                              <option value="UT"  <?php echo $state=="UT"?"selected":""?>>Utah</option>
                              <option value="VT"  <?php echo $state=="VT"?"selected":""?>>Vermont</option>
                              <option value="USVI"  <?php echo $state=="USVI"?"selected":""?>>VI  U.S. Virgin Islands</option>
                              <option value="VA"  <?php echo $state=="VA"?"selected":""?>>Virginia</option>
                              <option value="WA"  <?php echo $state=="WA"?"selected":""?>>Washington</option>
                              <option value="DC"  <?php echo $state=="DC"?"selected":""?>>Washington, D.C.</option>
                              <option value="WV"  <?php echo $state=="WV"?"selected":""?>>West Virginia</option>
                              <option value="WI"  <?php echo $state=="WI"?"selected":""?>>Wisconsin</option>
                              <option value="WY"  <?php echo $state=="WY"?"selected":""?>>Wyoming</option>
                          </optgroup>

                           <!-- FOR STRIPE UK -->
                          <optgroup label="England">
                           <option <?php echo $state=="Bedfordshire"?"selected":""?>>Bedfordshire</option>
                           <option <?php echo $state=="Berkshire"?"selected":""?>>Berkshire</option>
                           <option <?php echo $state=="Bristol"?"selected":""?>>Bristol</option>
                           <option <?php echo $state=="Buckinghamshire"?"selected":""?>>Buckinghamshire</option>
                           <option <?php echo $state=="Cambridgeshire"?"selected":""?>>Cambridgeshire</option>
                           <option <?php echo $state=="Cheshire"?"selected":""?>>Cheshire</option>
                           <option <?php echo $state=="City of London"?"selected":""?>>City of London</option>
                           <option <?php echo $state=="Cornwall"?"selected":""?>>Cornwall</option>
                           <option <?php echo $state=="Cumbria"?"selected":""?>>Cumbria</option>
                           <option <?php echo $state=="Derbyshire"?"selected":""?>>Derbyshire</option>
                           <option <?php echo $state=="Devon"?"selected":""?>>Devon</option>
                           <option <?php echo $state=="Dorset"?"selected":""?>>Dorset</option>
                           <option <?php echo $state=="Durham"?"selected":""?>>Durham</option>
                           <option <?php echo $state=="East Riding of Yorkshire"?"selected":""?>>East Riding of Yorkshire</option>
                           <option <?php echo $state=="East Sussex"?"selected":""?>>East Sussex</option>
                           <option <?php echo $state=="Essex"?"selected":""?>>Essex</option>
                           <option <?php echo $state=="Gloucestershire"?"selected":""?>>Gloucestershire</option>
                           <option <?php echo $state=="Greater London"?"selected":""?>>Greater London</option>
                           <option <?php echo $state=="Greater Manchester"?"selected":""?>>Greater Manchester</option>
                           <option <?php echo $state=="Hampshire"?"selected":""?>>Hampshire</option>
                           <option <?php echo $state=="Herefordshire"?"selected":""?>>Herefordshire</option>
                           <option <?php echo $state=="Hertfordshire"?"selected":""?>>Hertfordshire</option>
                           <option <?php echo $state=="Isle of Wight"?"selected":""?>>Isle of Wight</option>
                           <option <?php echo $state=="Kent"?"selected":""?>>Kent</option>
                           <option <?php echo $state=="Lancashire"?"selected":""?>>Lancashire</option>
                           <option <?php echo $state=="Leicestershire"?"selected":""?>>Leicestershire</option>
                           <option <?php echo $state=="Lincolnshire"?"selected":""?>>Lincolnshire</option>
                           <option <?php echo $state=="Merseyside"?"selected":""?>>Merseyside</option>
                           <option <?php echo $state=="Norfolk"?"selected":""?>>Norfolk</option>
                           <option <?php echo $state=="North Yorkshire"?"selected":""?>>North Yorkshire</option>
                           <option <?php echo $state=="Northamptonshire"?"selected":""?>>Northamptonshire</option>
                           <option <?php echo $state=="Northumberland"?"selected":""?>>Northumberland</option>
                           <option <?php echo $state=="Nottinghamshire"?"selected":""?>>Nottinghamshire</option>
                           <option <?php echo $state=="Oxfordshire"?"selected":""?>>Oxfordshire</option>
                           <option <?php echo $state=="Rutland"?"selected":""?>>Rutland</option>
                           <option <?php echo $state=="Shropshire"?"selected":""?>>Shropshire</option>
                           <option <?php echo $state=="Somerset"?"selected":""?>>Somerset</option>
                           <option <?php echo $state=="South Yorkshire"?"selected":""?>>South Yorkshire</option>
                           <option <?php echo $state=="Staffordshire"?"selected":""?>>Staffordshire</option>
                           <option <?php echo $state=="Suffolk"?"selected":""?>>Suffolk</option>
                           <option <?php echo $state=="Surrey"?"selected":""?>>Surrey</option>
                           <option <?php echo $state=="Tyne and Wear"?"selected":""?>>Tyne and Wear</option>
                           <option <?php echo $state=="Warwickshire"?"selected":""?>>Warwickshire</option>
                           <option <?php echo $state=="West Midlands"?"selected":""?>>West Midlands</option>
                           <option <?php echo $state=="West Sussex"?"selected":""?>>West Sussex</option>
                           <option <?php echo $state=="West Yorkshire"?"selected":""?>>West Yorkshire</option>
                           <option <?php echo $state=="Wiltshire"?"selected":""?>>Wiltshire</option>
                           <option <?php echo $state=="Worcestershire"?"selected":""?>>Worcestershire</option>
                       </optgroup>
                       <optgroup label="Scotland">
                           <option <?php echo $state=="Aberdeenshire"?"selected":""?>>Aberdeenshire</option>
                           <option <?php echo $state=="Angus"?"selected":""?>>Angus</option>
                           <option <?php echo $state=="Argyllshire"?"selected":""?>>Argyllshire</option>
                           <option <?php echo $state=="Ayrshire"?"selected":""?>>Ayrshire</option>
                           <option <?php echo $state=="Banffshire"?"selected":""?>>Banffshire</option>
                           <option <?php echo $state=="Berwickshire"?"selected":""?>>Berwickshire</option>
                           <option <?php echo $state=="Buteshire"?"selected":""?>>Buteshire</option>
                           <option <?php echo $state=="Cromartyshire"?"selected":""?>>Cromartyshire</option>
                           <option <?php echo $state=="Caithness"?"selected":""?>>Caithness</option>
                           <option <?php echo $state=="Clackmannanshire"?"selected":""?>>Clackmannanshire</option>
                           <option <?php echo $state=="Dumfriesshire"?"selected":""?>>Dumfriesshire</option>
                           <option <?php echo $state=="Dunbartonshire"?"selected":""?>>Dunbartonshire</option>
                           <option <?php echo $state=="East Lothian"?"selected":""?>>East Lothian</option>
                           <option <?php echo $state=="Fife"?"selected":""?>>Fife</option>
                           <option <?php echo $state=="Inverness-shire"?"selected":""?>>Inverness-shire</option>
                           <option <?php echo $state=="Kincardineshire"?"selected":""?>>Kincardineshire</option>
                           <option <?php echo $state=="Kinross"?"selected":""?>>Kinross</option>
                           <option <?php echo $state=="Kirkcudbrightshire"?"selected":""?>>Kirkcudbrightshire</option>
                           <option <?php echo $state=="Lanarkshire"?"selected":""?>>Lanarkshire</option>
                           <option <?php echo $state=="Midlothian"?"selected":""?>>Midlothian</option>
                           <option <?php echo $state=="Morayshire"?"selected":""?>>Morayshire</option>
                           <option <?php echo $state=="Nairnshire"?"selected":""?>>Nairnshire</option>
                           <option <?php echo $state=="Orkney"?"selected":""?>>Orkney</option>
                           <option <?php echo $state=="Peeblesshire"?"selected":""?>>Peeblesshire</option>
                           <option <?php echo $state=="Perthshire"?"selected":""?>>Perthshire</option>
                           <option <?php echo $state=="Renfrewshire"?"selected":""?>>Renfrewshire</option>
                           <option <?php echo $state=="Ross-shire"?"selected":""?>>Ross-shire</option>
                           <option <?php echo $state=="Roxburghshire"?"selected":""?>>Roxburghshire</option>
                           <option <?php echo $state=="Selkirkshire"?"selected":""?>>Selkirkshire</option>
                           <option <?php echo $state=="Shetland"?"selected":""?>>Shetland</option>
                           <option <?php echo $state=="Stirlingshire"?"selected":""?>>Stirlingshire</option>
                           <option <?php echo $state=="Sutherland"?"selected":""?>>Sutherland</option>
                           <option <?php echo $state=="West Lothian"?"selected":""?>>West Lothian</option>
                           <option <?php echo $state=="Wigtownshire"?"selected":""?>>Wigtownshire</option>
                       </optgroup>
                       <optgroup label="Wales">
                           <option <?php echo $state=="Anglesey"?"selected":""?>>Anglesey</option>
                           <option <?php echo $state=="Brecknockshire"?"selected":""?>>Brecknockshire</option>
                           <option <?php echo $state=="Caernarfonshire"?"selected":""?>>Caernarfonshire</option>
                           <option <?php echo $state=="Carmarthenshire"?"selected":""?>>Carmarthenshire</option>
                           <option <?php echo $state=="Cardiganshire"?"selected":""?>>Cardiganshire</option>
                           <option <?php echo $state=="Denbighshire"?"selected":""?>>Denbighshire</option>
                           <option <?php echo $state=="Flintshire"?"selected":""?>>Flintshire</option>
                           <option <?php echo $state=="Glamorgan"?"selected":""?>>Glamorgan</option>
                           <option <?php echo $state=="Merioneth"?"selected":""?>>Merioneth</option>
                           <option <?php echo $state=="Monmouthshire"?"selected":""?>>Monmouthshire</option>
                           <option <?php echo $state=="Montgomeryshire"?"selected":""?>>Montgomeryshire</option>
                           <option <?php echo $state=="Pembrokeshire"?"selected":""?>>Pembrokeshire</option>
                           <option <?php echo $state=="Radnorshire"?"selected":""?>>Radnorshire</option>
                       </optgroup>
                       <optgroup label="Northern Ireland">
                           <option <?php echo $state=="Antrim"?"selected":""?>>Antrim</option>
                           <option <?php echo $state=="Armagh"?"selected":""?>>Armagh</option>
                           <option <?php echo $state=="Down"?"selected":""?>>Down</option>
                           <option <?php echo $state=="Fermanagh"?"selected":""?>>Fermanagh</option>
                           <option <?php echo $state=="Londonderry"?"selected":""?>>Londonderry</option>
                           <option <?php echo $state=="Tyrone"?"selected":""?>>Tyrone</option>
                       </optgroup>
                      <!-- FOR STRIPE UK END-->
                           <option value="N/A"  <?php echo $state=="N/A"?"selected":""?>>Other</option>
                        </select>
                    <div class="clr"></div>
                       <label>ZIP/Postal Code:</label>
                    <input name="zip" id="zip" type="text" class="small-field"  value="<?php echo $zip;?>" onkeyup="checkFieldBack(this);" />
                    <div class="clr"></div>
                    
                     <label>E-mail:</label>
                    <input name="email" id="email" type="text" class="long-field"  value="<?php echo $email;?>" onkeyup="checkFieldBack(this);" />
                    <div class="clr"></div>
                </div>
                <!-- BILLING BLOCK -->
            
            
            	<!-- CREDIT CARD BLOCK -->
                <h2>Credit Card Information</h2>
                <div class="pane">
                   <label> I have:</label>
                    <input name="cctype" type="radio" value="V" class="lft-field" /> <img src="images/ico_visa.jpg" align="absmiddle" class="lft-field cardhide V" />
                    <input name="cctype" type="radio" value="M" class="lft-field" /> <img src="images/ico_mc.jpg" align="absmiddle" class="lft-field cardhide M" />
                    <input name="cctype" type="radio" value="A" class="lft-field" /> <img src="images/ico_amex.jpg" align="absmiddle" class="lft-field cardhide A" />
                    <input name="cctype" type="radio" value="D" class="lft-field" /> <img src="images/ico_disc.jpg" align="absmiddle" class="lft-field cardhide D" />
                    <?php if($enable_paypal){ ?>
                        <input name="cctype" type="radio" value="PP" class="lft-field isPayPal"  /> <img src="images/ico_paypal.png" width="37" height="11"  align="absmiddle" class="lft-field paypal cardhide PP"  />
                    <?php } ?>
                    <div class="clr"></div>
                    <div class="ccinfo">
                        <label>Card Number:</label>
                        <input name="ccn" id="ccn" type="text" class="long-field"  onkeyup="checkNumHighlight(this.value);checkFieldBack(this);noAlpha(this);" value="" onkeypress="checkNumHighlight(this.value);noAlpha(this);" onblur="checkNumHighlight(this.value);" onchange="checkNumHighlight(this.value);" maxlength="16" />
                        <span class="ccresult"></span>
                        <div class="clr"></div>

                        <label>Name on Card:</label>
                        <input name="ccname" id="ccname" type="text" class="long-field"  onkeyup="checkFieldBack(this);"  />
                        <div class="clr"></div>

                        <label>Expiration Date:</label>
                        <select name="exp1" id="exp1" class="small-field" onchange="checkFieldBack(this);">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <select name="exp2" id="exp2" class="small-field" onchange="checkFieldBack(this);">
                            <?php echo getActualYears();   ?>
                        </select>
                        <div class="clr"></div>

                        <label>CVV:</label>
                        <input name="cvv" id="cvv" type="text" maxlength="5" class="small-field"  onkeyup="checkFieldBack(this);noAlpha(this);"  />
                        <a href="hint.php" rel="hint" class="noscriptCase"><img src="images/ico_question.jpg" align="absmiddle" border="0" /></a>
                        <noscript>
                            <a href="hint.php" target="_blank"><img src="images/ico_question.jpg" align="absmiddle" border="0" /></a>
                        </noscript>
                    <div class="clr"></div>
                </div>


                    <div class="submit-btn"><input src="images/btn_submit.jpg" type="image" name="submit" /></div>
                    <input type="hidden" name="process" value="yes" />	
                </div>
            	<!-- CREDIT CARD BLOCK -->
                <?php } ?>
            
            </div>
        </form> 
    </div>
    

    
</div>

<!-- activate tabs with JavaScript -->
<script>
$(function() {
	$(".pane:not(:first)").hide();
	$("#accordion").tabs("#accordion div.pane", {tabs: 'h2', effect: 'slide', initialIndex: null});
});
</script>
<?php require "includes/site.footer.php"; ?>
