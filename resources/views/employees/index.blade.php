@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-0">
                    Empleados
                </h3>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>
                        Nombre
                    </th>
                    <th>
                        Email
                    </th>
                    <th>
                        Fecha de nacimiento
                    </th>
                    <th class="text-right">
                        Acción
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ Carbon\Carbon::parse($employee->birthday)->formatLocalized('%d/%m/%Y')  }}</td>
                        <td class="text-right">
                            <a href="{{ route('employees.show', ['$employee' => $employee->id]) }}" class="btn btn-link">
                                Ver info
                            </a>
                            <a href="{{ route('employees.edit', ['$employee' => $employee->id]) }}" class="btn btn-link">
                                Editar
                            </a>
                            <form action="{{ route('employees.destroy', ['$employee' => $employee->id]) }}"
                                  method="post"
                                class="float-right">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <button  type="submit" class="btn btn-link">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            No hay registros.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection