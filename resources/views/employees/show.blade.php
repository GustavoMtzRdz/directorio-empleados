@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div class="card mb-3">
            <div class="card-body">
                <h3 class="card-title mb-0">
                    {{ $employee->name }}
                </h3>
                <hr>
                <p>
                    <b>Email:</b> {{ $employee->email }}<br>
                </p>
                <hr>
                <p>
                    <b>Fecha de cumpleaños:</b> {{ Carbon\Carbon::parse($employee->birthday)->formatLocalized('%d/%m/%Y')  }}
                </p>
            </div>
        </div>
        <div class="card">
            <div class="card-body mb-2">
                <h4 class="card-title mb-0">
                    Direcciones
                </h4>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Alias</th>
                        <th>Dirección</th>
                        <th>Mapa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employee->addresses as $address)
                        <tr>
                            <td>
                                {{ $address->alias }}
                            </td>
                            <td>
                                {{ $address->address }}
                            </td>
                            <td>
                                <button class="btn btn-link" data-address="{{ $address->address }}" data-toggle="modal" data-target="#mapModal">Ver mapa</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No hay registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe src="" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('#mapModal').on('show.bs.modal', function (event) {

            var button = $(event.relatedTarget);
            var address = button.data('address');

            var modal = $(this);
            modal.find('iframe').attr('src', 'https://www.google.com/maps/embed/v1/place?key=AIzaSyBLkGj3K3lnIVTaFYiyiUSO-_0C2--h3mY&q=' + address);
        })
    </script>
@endpush