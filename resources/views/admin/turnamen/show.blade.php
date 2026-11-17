@extends('layouts.admin', ['title' => 'Detail Turnamen & Season'])

@section('content')
<livewire:tournament-detail :tournamentId="$id" />
@endsection
