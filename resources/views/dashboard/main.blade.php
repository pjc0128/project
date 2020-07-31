
@extends('layout.table_layout')
@section('table_name', '메일 이력')

@section('table')
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
            <td>{{$result['mail_contents']->firstItem()+$loop->index}}</td>
            <td>{{date_format($mail_content->created_at, 'Y-m-d')}}</td>
            <td>
                <a href='/dashboard/detail?mid={{$mail_content->id}}&mail_title={{date_format($mail_content->created_at, 'Y-m-d').'사람인기사'}}'>
                    {{date_format($mail_content->created_at, 'Y-m-d').'사람인기사'}}
                </a>
            </td>
            <td>{{$mail_content->total}}</td>
            <td>{{$mail_content->success}}</td>
            <td>{{$mail_content->fail}}</td>
        </tr>
    @endforeach
    </tbody>
@endsection

@section('pagination')
    {{$result['mail_contents']}}
@endsection

@section('showing')
    Showing {{$result['mail_contents']->firstItem()}} to {{$result['mail_contents']->lastItem()}} of {{$result['mail_contents']->total()}} entries
@endsection
