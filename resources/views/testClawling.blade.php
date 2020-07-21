<?php

?>
@foreach($articles as $article)
    title : {{$article['title']}}<br>
    url : {{$article['url']}}<br>
    date : {{$article['date']}}<br>
@endforeach
