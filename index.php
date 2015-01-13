<html>
  <head>
    <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Laatst getwitterde Correspondentlinks</title>

      <!-- Bootstrap -->
      <link href="assets/css/bootstrap.min.css" rel="stylesheet">
      <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <h3>
      <i class="fa fa-twitter fa-2x"> 
      </i>Een lijst met de laatst getwitterde Correspondentlinks:
    </h3>
  </body> 
  <ul class="list-group">
    <?php
      require_once('TwitterAPIExchange.php');
      include('config_tokens.php');

      $settings = array(
          'oauth_access_token' => $access_token,
          'oauth_access_token_secret' => $access_token_secret,
          'consumer_key' => $consumer_key,
          'consumer_secret' => $consumer_secret
      );
      $hide_url = "http://refhide.com/?";

      $url = 'https://api.twitter.com/1.1/search/tweets.json';
      $requestMethod = 'GET';
      $getfield = '?f=realtime&q=decorrespondent.nl%2F&src=typd';
      $twitter = new TwitterAPIExchange($settings);    
      $api_response = $twitter ->setGetfield($getfield)
                           ->buildOauth($url, $requestMethod)
                           ->performRequest();

      $response = json_decode($api_response);

      foreach($response->statuses as $tweet)
        {
          $tweeted_url = "{$tweet->entities->urls[0]->expanded_url}";
          echo '<li class="list-group-item">';
          #echo "<a href=$hide_url{$tweet->entities->urls[0]->expanded_url} target=blank>{$tweet->entities->urls[0]->expanded_url}</a>\n ";

          $test = preg_replace('/[0-9]+/', '', $tweeted_url);
          $test2 = preg_replace('https\:\/\/decorrespondent\.nl', '', $test);
          echo $tes2;


          // function convertSpace($string) {
          //   return str_replace("-", " ", $string);
          // }

          // $string = $tweeted_url;

          // echo filter_var($string, FILTER_CALLBACK,
          // array("options"=>"convertSpace"));

          // echo '</li>';
        }
    ?>
  </ul>
  <footer class="footer">
    <div class="container">
       <p class="text-muted">Disclaimer: Dit is niet bedoeld voor commercieel gebruik maar als oefening om te programmeren.</p>
    </div>
  </footer>
</html>
