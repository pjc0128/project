
@extends('layout.table_layout')
@section('table_name', '기사')

@section('table')
    <thead>
        <tr>
            <td></td>
            <td>제목</td>
            <td>url</td>
            <td>생성일</td>
        </tr>
    </thead>
    <tbody>

    @foreach($result['articles'] as $article)
        <tr>
            <td>{{$result['articles']->firstItem()+$loop->index}}</td>
            <td>{{$article->title}}</td>
            <td>
                @if($article->type == "I")
                    <a href="{{getenv('PRE').$article->url}}">{{$article->url}}</a>
                @endif
                @if($article->type == "D")
                    <strike>{{$article->url}}</strike>
                @endif
            </td>

            <td>{{date_format($article->created_at, 'Y-m-d')}}</td>
        </tr>
    @endforeach
    </tbody>
@endsection

@section('pagination')
    {{$result['articles']}}
@endsection

@section('showing')
    Showing {{$result['articles']->firstItem()}} to {{$result['articles']->lastItem()}} of {{$result['articles']->total()}} entries
@endsection
