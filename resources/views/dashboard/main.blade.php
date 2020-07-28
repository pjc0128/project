<?php

?>
<style>
    table, th, td {
        border : 1px solid black;
    }

</style>
<table>
    <thead>
    <tr>
        <td></td>
        <td>발송일</td>
        <td>메일 내용 보기</td>
        <td>대상자 수</td>
        <td>발송 성공</td>
        <td>발송 실패</td>
    </tr>
    </thead>
    <tbody>

    @foreach($result['mail_contents'] as $mail_content)
        <tr>
            <td>{{$mail_content->id}}</td>
            <td>{{date_format($mail_content->created_at, 'Y-m-d')}}</td>
            <td><a href='/dashboard/detail?mid={{$mail_content->id}}'>{{date_format($mail_content->created_at, 'Y-m-d').'사람인기사'}}</a></td>
            <td>{{$mail_content->total}}</td>
            <td>{{$mail_content->success}}</td>
            <td>{{$mail_content->fail}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
