@extends('layouts.admin')

@section('title')
Servidor — {{ $server->name }}: Mounts
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Gerenciar montagens do servidor.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Administração</a></li>
        <li><a href="{{ route('admin.servers') }}">Servidores</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Montagens</li>
    </ol>
@endsection

@section('content')
    @include('admin.servers.partials.navigation')

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Montagens disponíveis</h3>
                </div>

                <div class="box-body table-responsible no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Origem</th>
                            <th>Objetivo</th>
                            <th>Status</th>
                            <th></th>
                        </tr>

                        @foreach ($mounts as $mount)
                            <tr>
                                <td class="col-sm-1 middle"><code>{{ $mount->id }}</code></td>
                                <td class="middle"><a href="{{ route('admin.mounts.view', $mount->id) }}">{{ $mount->name }}</a></td>
                                <td class="middle"><code>{{ $mount->source }}</code></td>
                                <td class="col-sm-2 middle"><code>{{ $mount->target }}</code></td>

                                @if (! in_array($mount->id, $server->mounts->pluck('id')->toArray()))
                                    <td class="col-sm-2 middle">
                                        <span class="label label-primary">Unmounted</span>
                                    </td>

                                    <td class="col-sm-1 middle">
                                        <form action="{{ route('admin.servers.view.mounts.store', [ 'server' => $server->id ]) }}" method="POST">
                                            {!! csrf_field() !!}
                                            <input type="hidden" value="{{ $mount->id }}" name="mount_id" />
                                            <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></button>
                                        </form>
                                    </td>
                                @else
                                    <td class="col-sm-2 middle">
                                        <span class="label label-success">Montado</span>
                                    </td>

                                    <td class="col-sm-1 middle">
                                        <form action="{{ route('admin.servers.view.mounts.delete', [ 'server' => $server->id, 'mount' => $mount->id ]) }}" method="POST">
                                            @method('DELETE')
                                            {!! csrf_field() !!}

                                            <button type="submit" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection