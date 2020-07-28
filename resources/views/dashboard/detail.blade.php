
<style>
    table, th, td {
        border : 1px solid black;
    }

</style>


<table id="mail_histories">
    <thead>

    </thead>
    <tbody>
    @foreach($result['articles'] as $article)
        <tr>

            <td>{{$article->title}}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<table id="histories">
    <thead>
        <tr>
            <td>메일</td>
            <td>발송 시간</td>
            <td>유입 시간</td>
        </tr>
    </thead>
    <tbody>

    @foreach($result['mail_histories'] as $mail_history)
        <tr>
            <td>{{$mail_history->email}}</td>
            <td>{{$mail_history->send_time}}</td>
            <td>{{$mail_history->access_time}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
