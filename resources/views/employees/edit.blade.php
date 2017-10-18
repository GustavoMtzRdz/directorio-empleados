@extends('layouts.app')

@section('content')
    <div class="container" id="app">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title mb-0">
                    Nuevo empleado
                </h3>
                <hr>
                @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="post" class="row">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <div class="form-group col-sm-12">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $employee->name }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ $employee->email }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="birthday">Fecha de nacimiento</label>
                        <input type="date" id="birthday" name="birthday" class="form-control" value="{{ $employee->birthday }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-info">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>

        var vm = new Vue({
            el: '#app',

            data: {
                button: {
                    submit: ''
                },

                inputs: {
                    phones: {
                        count: 0
                    }
                }

            },

            methods: {

                store: function (event) {
                    loadingSubmit(event);
                },

                addFields: function (el) {

                    this.inputs.phones.count++;
                    var container = $(el);
                    var defaultFields = container.find('.default-fields').clone();

                    defaultFields.find('.row').addClass('row-' + this.inputs.phones.count);
                    defaultFields
                        .find('.remove-field')
                        .html(
                            '<button class="btn btn-danger btn-sm float-right mt-4" type="button"  onclick="vm.removeFields(\'' + el +'\', ' + this.inputs.phones.count + ')">\n' +
                            '-' +
                            '</button>'
                        );

                    defaultFields.find('.form-control').attr('value', '');
                    container.find('.list-fields').append(defaultFields.html());

                },

                removeFields: function (el, row) {

                    var container = $(el);
                    container.find('.row-' + row).remove();
                }
            }
        })

    </script>
@endpush