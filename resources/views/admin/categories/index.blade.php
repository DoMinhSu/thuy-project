@extends('layouts.app')
@section('title', 'Categories list')
    @push('stylesheet')
        .modal-backdrop{
        display:none;
        }
    @endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>
                <div class="breadcrumb-item">Table</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="#" id="create" class="btn btn-primary">Create</a>
                        </div>
                        <div class="card-body">
                            <div class="section-title mt-0">Light</div>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Slug</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $model)
                                        <tr>
                                            <th scope="row">{{ $model->name }}</th>
                                            <th scope="row">{{ $model->slug }}</th>
                                            <th scope="row">
                                                <div class="buttons">
                                                    <a href="#" data-id="{{ $model->id }}"
                                                        class="editButton btn btn-success">Edit</a>
                                                    <a href="{{ route('admin.'.$table.'.delete', ['model' => $model->id]) }}"
                                                        class="btn btn-danger">Delete</a>
                                                </div>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $data->links() }}




                        <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modelTitle">...</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="#" id="createEditForm" method="post">
                                        @csrf
                                        @method('post')
                                        <input type="hidden" id="_id" name="_id" value="">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="submitName"
                                                type="submit">Edit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('javascript')
    <script>
        const updateUrl = "{!! route('admin.'.$table.'.update') !!}";
        const createUrl = "{!! route('admin.'.$table.'.store') !!}";
        const submitButton = document.getElementById('submitName')
        const form = document.getElementById("createEditForm")
        const modelTitle = document.getElementById('modelTitle')
        const _id = $('#_id')
        const method = document.getElementsByName('_method')[0].getAttribute('value')
        const editModel = $('#editModal')

        document.getElementById("create").addEventListener('click', function(e) {
            e.preventDefault()
            openModel(true)
        })


        modelTitle.innerText = "Edit"
        var data = @json($data).data;
        var editButtons = document.getElementsByClassName('editButton')
        Array.prototype.forEach.call(editButtons, function(el) {
            el.addEventListener("click", function(e) {
                e.preventDefault()
                const id = parseInt(this.getAttribute('data-id'));
                var item = _.find(data, {
                    id: id
                })
                for (var key in item) {
                    $("#editModal input[name=" + key + "]").val(item[key]);
                }
                openModel(false,id)

            })
        });
        editModel.on('hidden.bs.modal', function(e) {
            form.reset();
            form.setAttribute('action', "#");
        })
        submitButton.addEventListener('click', async function(e) {
            form.submit()
            // e.preventDefault()
            // const result = await axios({
            //     method: method,
            //     url: form.getAttribute('action'),
            //     data: $("#createEditForm").serializeArray(),

            // });
            // console.log(result);
            // form.reset()
            // editModel.modal('hide')
        })

        function openModel(isCreate = false,id=false) {
            console.log(id);
            if (!isCreate) {
                modelTitle.innerText = "Update"
                submitButton.innerText = "Update"
                form.setAttribute('action', updateUrl);


            } else {
                modelTitle.innerText = "Create"
                submitButton.innerText = "Create"
                form.setAttribute('action', createUrl);

            }
            if(id){
                _id.val(id)
            }
            editModel.modal()
        }
    </script>
@endpush
