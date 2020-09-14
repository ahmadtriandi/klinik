<?php

use Joomla\Registry\Format\Php;

function get_CURL($url)
{

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);

    return json_decode($result, true); //untuk di jadikan array
}

$result = get_CURL('https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=UCkXmLjEr95LVtGuIm3l2dPg&key=AIzaSyAG4BQkWV541xfd-cDi7Y40QFMLJY6bQJ0');
$youtubeProfilePic = $result['items'][0]['snippet']['thumbnails']['medium']['url'];
$youtubeNamaAccount = $result['items'][0]['snippet']['title'];
$youtubeSubscriber = $result['items'][0]['statistics']['subscriberCount'];

//latest video
$urlLatestVideo = 'https://www.googleapis.com/youtube/v3/search?part=snippet&channelId=UCkXmLjEr95LVtGuIm3l2dPg&maxResults=1&key=AIzaSyAG4BQkWV541xfd-cDi7Y40QFMLJY6bQJ0&order=date';

$result1 = get_CURL($urlLatestVideo);
$youtubeLatestVideo = $result1['items'][0]['id']['videoId'];



//instagram Api

$clientId = '859735457848515';
$accessToken = 'EAAbBFtaPxX4BAJIlM3M0q4YZCftrtIzP6Ruy8u5skyrPyV7pOTN6ZAknKdmFlLyVvaKdZBvkieqI9ZAopnATwMfi8LQblG2gMwhtq1ZB2FItnEJIOSAvSjPaAb2EqhnJBt3MXaXdkQLmQZBaQMG7LZBGcC49pOGckRW7tlJKqPGCgZDZD';

$result = get_CURL('https://graph.facebook.com/v7.0/17841404890124240?fields=username,followers_count,profile_picture_url,biography&access_token=' . $accessToken . '');

$usernameIG = $result['username'];
$profilePictureIG = $result['profile_picture_url'];
$followerIG = $result['followers_count'];
$biographyIG = $result['biography'];

//media
$result = get_CURL('https://graph.facebook.com/v7.0/17841404890124240?fields=business_discovery.username(gragestone_official){username,website,name,ig_id,id,profile_picture_url,biography,follows_count,followers_count,media_count,media{caption,like_count,comments_count,media_url,permalink,media_type}}&access_token=' . $accessToken . '');

$photosIG = [];
foreach ($result['business_discovery']['media']['data'] as $photo) {
    if ($photo['media_type'] == 'IMAGE') {
        $photosIG[] = $photo['media_url'];
    }



    // hashtag

    $result = get_CURL('https://graph.facebook.com/v7.0/17843824174048335/recent_media?user_id=17841404890124240&fields=media_type,media_url&access_token=' . $accessToken . '&limit=20');

    $hashtagIG = [];

    foreach ($result['data'] as $hashtag) {
        if ($hashtag['media_type'] == 'IMAGE') {
            $hashtagIG[] = $hashtag['media_url'];
        }
    }
}



?>

<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="jumbotron" id="home">
    <div class="container">
        <div class="text-center">
            <img src="img/profile1.png" class="rounded-circle img-thumbnail">
            <h1 class="display-4">Sandhika Galih</h1>
            <h3 class="lead">Lecturer | Programmer | Youtuber</h3>
        </div>
    </div>
</div>


<!-- About -->
<section class="about" id="about">
    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h2>About</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, molestiae sunt doloribus error ullam expedita cumque blanditiis quas vero, qui, consectetur modi possimus. Consequuntur optio ad quae possimus, debitis earum.</p>
            </div>
            <div class="col-md-5">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, molestiae sunt doloribus error ullam expedita cumque blanditiis quas vero, qui, consectetur modi possimus. Consequuntur optio ad quae possimus, debitis earum.</p>
            </div>
        </div>
    </div>
</section>

<!-- Youtube & IG -->
<section class="social bg-light " id="social">
    <div class="container">
        <div class="row pt-4 mb-4">
            <div class="col text-center">
                <h2>Social Media</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-4">
                        <img class="img-thumbnail rounded-circle" width="200px" src="<?= $youtubeProfilePic ?>" alt="">
                    </div>
                    <div class="col-md-8">
                        <h5><?= $youtubeNamaAccount; ?></h5>
                        <p><?= $youtubeSubscriber; ?> Subscribers</p>
                        <div class="g-ytsubscribe" data-channelid="UCkXmLjEr95LVtGuIm3l2dPg" data-layout="default" data-theme="dark" data-count="default"></div>
                    </div>
                </div>

                <div class="row mt-3 pb-3">
                    <div class="col">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $youtubeLatestVideo; ?>" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IG -->

            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-4">
                        <img class="img-thumbnail rounded-circle" width="200px" src="<?= $profilePictureIG; ?>" alt="">
                    </div>
                    <div class="col-md-8">
                        <h5><?= $usernameIG; ?></h5>
                        <p><?= $followerIG; ?> Followers.</p>
                        <p><?= $biographyIG; ?> <p>
                    </div>
                </div>

                <div class="row mt-3 pb-3">
                    <div class="col">
                        <?php foreach ($photosIG as $photo) : ?>
                            <div class="ig-thumbnail mr-1">
                                <img src="<?= $photo; ?>" alt="">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>


<!-- hashtag #kmupdates -->
<section class="hashtag" id="hashtag">
    <div class="container">
        <div class="row pt-4 mb-4">
            <div class="col text-center">
                <h2>Hashtag<span class="font-italic text-warning"> #kmupdates</span></h2>
            </div>
        </div>

        <div class="tz-gallery">
            <div class="row justify-content-center">
                <?php foreach ($hashtagIG as $hashtagIG) : ?>
                    <a class="lightbox" href="<?= $hashtagIG; ?>">
                        <div class="col ">
                            <div class="ig-thumbnail mr-1 mb-1">
                                <img src="<?= $hashtagIG; ?>" alt="">
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Portfolio -->
<section class="portfolio" id="portfolio">
    <div class="container">
        <div class="row pt-4 mb-4">
            <div class="col text-center">
                <h2>Portfolio</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md mb-4">
                <div class="card">
                    <img class="card-img-top" src="img/thumbs/1.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>

            <div class="col-md mb-4">
                <div class="card">
                    <img class="card-img-top" src="img/thumbs/2.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>

            <div class="col-md mb-4">
                <div class="card">
                    <img class="card-img-top" src="img/thumbs/3.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md mb-4">
                <div class="card">
                    <img class="card-img-top" src="img/thumbs/4.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="col-md mb-4">
                <div class="card">
                    <img class="card-img-top" src="img/thumbs/5.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md mb-4">
                <div class="card">
                    <img class="card-img-top" src="img/thumbs/6.png" alt="Card image cap">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Contact -->
<section class="contact bg-light" id="contact">
    <div class="container">
        <div class="row pt-4 mb-4">
            <div class="col text-center">
                <h2>Contact</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="card bg-primary text-white mb-4 text-center">
                    <div class="card-body">
                        <h5 class="card-title">Contact Me</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>

                <ul class="list-group mb-4">
                    <li class="list-group-item">
                        <h3>Location</h3>
                    </li>
                    <li class="list-group-item">My Office</li>
                    <li class="list-group-item">Jl. Setiabudhi No. 193, Bandung</li>
                    <li class="list-group-item">West Java, Indonesia</li>
                </ul>
            </div>

            <div class="col-lg-6">

                <form>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control" id="message" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary">Send Message</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>


<?= $this->endSection(); ?>