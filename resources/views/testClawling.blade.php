<?php

?>
@foreach($articles as $article)
    title : {{$article['title']}}<br>
    url : {{$article['url']}}<br>
@endforeach
