@extends('sibaf::layouts.masterinstructor')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('sibaf.name') !!}
    </p>
@endsection
