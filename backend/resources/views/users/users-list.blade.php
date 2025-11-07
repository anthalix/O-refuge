@extends('layouts.app')

@section('content')

<h1>Liste des Utilisateurs :</h1>
<table class="table">
    <thead>
        <tr>
            <th>nom</th>
            <th>email</th>
            <th>rôles</th>
            <th>action</th>


        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td><strong>{{ $user->username }}</strong></td>
            <td>{{ $user->email }}</td>
            <td>
                @foreach (json_decode($user->roles) as $role)
                <span class="badge bg-primary">{{ $role }}</span>
                @endforeach
            </td>


            <td>
                <form action="{{route('users.delete', ['id' =>$user->id])}}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>


@endsection