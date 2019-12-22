<?php
function menu($profile) 
{
	global $themes;

	if($profile)
	{
		return '<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="'.$themes['home_url'].'">رُفوف</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> القائمة
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="'.$themes['home_url'].'" class="nav-link">الرئيسية</a></li>
          <li class="nav-item"><a class="nav-link" href="'.$themes['explore_url'].'">أستكشف الأقرب</a></li>
          <li class="nav-item"><a class="nav-link" href="'.$themes['logout_url'].'">تسجيل الخروج</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->';
	}
	else
	{
		return '<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
      <a class="navbar-brand" href="'.$themes['home_url'].'">رُفوف</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="oi oi-menu"></span> القائمة
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active"><a href="'.$themes['home_url'].'" class="nav-link">الرئيسية</a></li>
          <li class="nav-item"><a class="nav-link" href="'.$themes['explore_url'].'">أستكشف الأقرب</a></li>
          <li class="nav-item"><a class="nav-link" href="'.$themes['login_url'].'">تسجيل الدخول</a></li>
          <li class="nav-item cta"><a href="'.$themes['register_url'].'" class="nav-link"><span>جرب رُفوف الآن</span></a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- END nav -->';

	}
}


function getNearestLocations() 
{	
	global $db, $configs;

	if(isset($_COOKIE["latitude"]) && isset($_COOKIE["longitude"]))
	{
		$query = $db->query(sprintf("SELECT *, SQRT(POW(69.1 * (`latitude` - '%s'), 2) + POW(69.1 * ('%s' - `longitude`) * COS(`latitude` / 57.3), 2)) AS `distance` FROM `profiles` ORDER BY distance", $db->real_escape_string($_COOKIE["latitude"]), $db->real_escape_string($_COOKIE["longitude"]) ));


		
		$aa = '<section class="ftco-section testimony-section bg-light">

			<div class="row justify-content-center mb-5 pb-5">
				      <div class="col-md-7 text-center heading-section ftco-animate">
				        <h2 class="mb-4">أستكشف الأقرب إليك</h2>
				      </div>
				    </div>
				    
				  <div class="container">
				    <div class="row ftco-animate">
				      <div class="col-md-12">
				        <div class="carousel-testimony owl-carousel ftco-owl">';	        
        while ($row = $query->fetch_assoc()) 
        {
        	
        	$persian = ['۰', '۱', '۲', '۳', '٤', '٥', '٦', '۷', '۸', '۹'];
    		$english = [ 0 ,  1 ,  2 ,  3 ,  4 ,  5 ,  6 ,  7 ,  8 ,  9 ];
        	$distance = str_replace($english, $persian, round($row['distance'], 2) ) ;
        	$aa .= '
				          <div class="item">
				            <div class="testimony-wrap p-4 pb-5">
				                <center>
				                    <a href="'.$configs['url'].'/'.'p.php?u='.$row['username'].'">
				                    <div class="user-img mb-5" style="background-image: url(http://localhost:8080/qa-project/thumb.php?t=l&src=default.png&q=50)">
				                    <span class="quote d-flex align-items-center justify-content-center">
				                      <i class="fas fa-location-arrow"></i>
				                    </span>
				                    </div>
				                    </a>
				                    <img width="75" height="13" src="'.$configs['url'].'/'.$configs['theme_url'].'/images/rating/'.$row['rating'].'.svg">
				                </center>
				                <div class="text">
				                    <a href="'.$configs['url'].'/'.'p.php?u='.$row['username'].'"><p class="mb-2">'.$row['name'].'</p></a>
				                    <p class="mb-2">'.$row['address'].' <i class="fa fa-map-marker-alt"></i></p>
				                    <span class="position font-weight-bold">'.$distance.' </span>

				                </div>
				            </div>
				          </div>';
				         
				          
				       
        }
        $aa .= ' </div>
				      </div>
				    </div>
				  </div>
				</section>';

		return $aa;
	}
	else
	{
		return '<section class="ftco-section testimony-section bg-light">
				  <div class="container">
				    <div class="row justify-content-center mb-5 pb-5">
				      <div class="col-md-7 text-center heading-section ftco-animate">
				        <h2 class="mb-4">أستكشف الأقرب إليك</h2>
				        <a onclick="getLocation();window.location.reload();" class="btn btn-primary px-4 py-3">عرض أقرب المتاجر أ، المطاعم أ، الشركات</a>
				      </div>
				    </div>
				  </div>
				</section>';
	}
}

function notificationBox($type, $message) 
{
	return "<div class='".$type." text-center'>".$message."</div>";
}

?>