<!DOCTYPE html>
<html lang="en">
	<!-- Title bar -->
		<title>AppMapper </title>
		<head>
		<style>
		body{
		font-family:Hp Simplified;
		}
		
		.btn {
  -webkit-border-radius: 4;
  -moz-border-radius: 4;
  border-radius: 4px;
  font-family: Arial;
  color: #ffffff;
  font-size: 12px;
  background: #33b5e5;
  padding: 8px 16px 8px 16px;
  text-decoration: none;
  border: none;
    outline: none;
}

.btn:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  
  text-decoration: none;
}
	#cssmenu {
  
  
  margin: 0;
  background:#33b5e5;
  
}
#cssmenu ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: block;
}
#cssmenu ul:after {
  content: ' ';
  display: block;
  
  height: 0;
  clear: both;
  visibility: hidden;
}
#cssmenu ul li {
  margin: 0;
  padding: 0;
  display: block;
  position: relative;
}
#cssmenu ul li a {
  text-decoration: none;
  display: block;
  margin: 0;
  -webkit-transition: color .2s ease;
  -moz-transition: color .2s ease;
  -ms-transition: color .2s ease;
  -o-transition: color .2s ease;
  transition: color .2s ease;
}
#cssmenu ul li ul {
  position: absolute;
  left: -9999px;
  top: auto;
}
#cssmenu ul li ul li {
  max-height: 0;
  position: absolute;
  -webkit-transition: max-height 0.4s ease-out;
  -moz-transition: max-height 0.4s ease-out;
  -ms-transition: max-height 0.4s ease-out;
  -o-transition: max-height 0.4s ease-out;
  transition: max-height 0.4s ease-out;
  background:#33b5e5	;
}
#cssmenu ul li ul li.has-sub:after {
  display: block;
  position: absolute;
  content: '';
  height: 10px;
  width: 10px;
  border-radius: 5px;
  background: #666666;
  z-index: 1;
  top: 13px;
  right: 15px;
}
#cssmenu ul li ul li.has-sub:before {
  display: block;
  position: absolute;
  content: '';
  height: 0;
  width: 0;
  border: 3px solid transparent;
  border-left-color: #ffffff;
  z-index: 2;
  top: 15px;
  right: 15px;
}
#cssmenu ul li ul li a {
  text-transform: none;
  color: white;
  letter-spacing: 0;
  display: block;
  width: 140px;
  padding: 11px 10px 11px 20px;
}
#cssmenu ul li ul li:hover > a,
#cssmenu ul li ul li.active > a {
  color: #666666;
}
#cssmenu ul li ul li:hover:after,
#cssmenu ul li ul li.active:after {
  background:#33b5e5;
}
#cssmenu ul li ul li:hover > ul {
  left: 170px;
  top: 0;
}
#cssmenu ul li ul li:hover > ul > li {
  max-height: 72px;
  position: relative;
}
#cssmenu > ul > li {
  float: left;
}
#cssmenu > ul > li:after {
  content: '';
  display: block;
  position: absolute;
  width: 100%;
  height: 0;
  top: 0;
  z-index: 0;
  background:#33b5e5;
  color:#666666;
  -webkit-transition: height .2s;
  -moz-transition: height .2s;
  -ms-transition: height .2s;
  -o-transition: height .2s;
  transition: height .2s;
}
#cssmenu > ul > li.has-sub > a {
  padding-right: 40px;
}
#cssmenu > ul > li.has-sub > a:after {
  display: block;
  content: '';
  background: #ffffff;
  height: 12px;
  width: 12px;
  position: absolute;
  border-radius: 13px;
  right: 14px;
  top: 16px;
}
#cssmenu > ul > li.has-sub > a:before {
  display: block;
  content: '';
  border: 4px solid transparent;
  border-top-color:#33b5e5;
  z-index: 2;
  height: 0;
  width: 0;
  position: absolute;
  right: 16px;
  top: 21px;
}
#cssmenu > ul > li > a {
  color: #ffffff;
  padding: 15px 20px;
  letter-spacing: 1px;
  
  font-size: 16px;
  z-index: 2;
  position: relative;
}
#cssmenu > ul > li:hover:after,
#cssmenu > ul > li.active:after {
  height: 100%;
}
#cssmenu > ul > li:hover > a,
#cssmenu > ul > li.active > a {
  color: #666666;
}
#cssmenu > ul > li:hover > a:after,
#cssmenu > ul > li.active > a:after {
  background: #666666;
}
#cssmenu > ul > li:hover > a:before,
#cssmenu > ul > li.active > a:before {
  border-top-color: #ffffff;
}
#cssmenu > ul > li:hover > ul {
  left: 0;
}
#cssmenu > ul > li:hover > ul > li {
  max-height: 72px;
  position: relative;
}
#cssmenu #menu-button {
  display: none;
}
@media all and (max-width: 768px), only screen and (-webkit-min-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (min--moz-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (-o-min-device-pixel-ratio: 2/1) and (max-width: 1024px), only screen and (min-device-pixel-ratio: 2) and (max-width: 1024px), only screen and (min-resolution: 192dpi) and (max-width: 1024px), only screen and (min-resolution: 2dppx) and (max-width: 1024px) {
  #cssmenu > ul {
    max-height: 0;
    overflow: hidden;
    -webkit-transition: max-height 0.35s ease-out;
    -moz-transition: max-height 0.35s ease-out;
    -ms-transition: max-height 0.35s ease-out;
    -o-transition: max-height 0.35s ease-out;
    transition: max-height 0.35s ease-out;
  }
  #cssmenu > ul.open {
    max-height: 1000px;
    border-top: 1px solid rgba(110, 110, 110, 0.25);
  }
  #cssmenu ul {
    width: 100%;
  }
  #cssmenu ul > li {
    float: none;
  }
  #cssmenu ul li a {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
    padding: 12px 20px;
  }
  #cssmenu ul > li:after {
    display: none;
  }
  #cssmenu ul li.has-sub > a:after,
  #cssmenu ul li.has-sub > a:before,
  #cssmenu ul li ul li.has-sub:after,
  #cssmenu ul li ul li.has-sub:before {
    display: none;
  }
  #cssmenu ul li ul,
  #cssmenu ul li ul li ul,
  #cssmenu ul li ul li:hover > ul {
    left: 0;
    position: relative;
  }
  #cssmenu ul li ul li,
  #cssmenu ul li:hover > ul > li {
    max-height: 999px;
    position: relative;
    background: none;
  }
  #cssmenu ul li ul li a {
    
    color: #ffffff;
    width: auto;
  }
  #cssmenu ul li ul ul li a {
    padding: 8px 20px 8px 50px;
  }
  #cssmenu ul li ul li:hover > a {
    color: #666666;
  }
  #cssmenu #menu-button {
    display: block;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
    
    letter-spacing: 1px;
    color: #ffffff;
    cursor: pointer;
  }
  #cssmenu #menu-button:after {
    display: block;
    content: '';
    position: absolute;
    height: 3px;
    width: 22px;
    border-top: 2px solid #ffffff;
    border-bottom: 2px solid #ffffff;
    right: 20px;
    top: 16px;
  }
  #cssmenu #menu-button:before {
    display: block;
    content: '';
    position: absolute;
    height: 3px;
    width: 22px;
    border-top: 2px solid #ffffff;
    right: 20px;
    top: 26px;
  }
}

		</style>
		  </head>





	<!-- div for menu -->
		<div id='cssmenu' style="font-family:Arial;text-decoration-none;position: fixed;top: 0px;left: 0px;right: 0px;width: 100%;">
		<ul>
		<!-- List of menu -->
			<li class='last'><a href="<?php echo base_url().'index.php/nagger'; ?>"><span>Home</span></a></li>
			
			<font style="float:right;color:white">
				
				<!-- current session user -->
					<?php 
						echo '<br/>'.$this->session->userdata('email').'&nbsp &nbsp ';
						
					?>
			</font>
		</ul>
		</div>
</br>
</br>
</br>
