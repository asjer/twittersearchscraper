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

          $pattern = '/https:\/\/decorrespondent\.nl\/|0|1|2|3|4|5|6|7|8|9/';
          $replacement = '';
          $string_new = preg_replace($pattern, $replacement, $tweeted_url);
          #echo "string_new: $string_new <br>";

          $pattern2 = '/-/';
          $replacement2 = ' ';
          $string_new2 = preg_replace($pattern2, $replacement2, $string_new);
          #echo "string_new2: $string_new2 <br>";

          $pattern3 = '/\//';
          $replacement3 = '';
          $string_new3 = preg_replace($pattern3, $replacement2, $string_new2);
          #echo "string_new3: $string_new3 <br>";

          $pattern4 = '/http\:\s+fb\.me|http\:\s+bit\.ly/';
          $replacement4 = '';
          $string_new4 = preg_replace($pattern4, $replacement4, $string_new3);
          #echo "fb en bitly delete: $string_new4 <br>";

          $lastSpacePosition = strrpos($string_new4, ' ');
          $last_string = substr($string_new4, 0, $lastSpacePosition);

          $last_string2=preg_replace("/[\n\r]/","",$last_string);

          echo "<a href=$hide_url{$tweet->entities->urls[0]->expanded_url} target=blank>$last_string2</a>\n ";

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
