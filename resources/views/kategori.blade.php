@extends('layouts.layout')

@section('title', 'Kategori')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Kategori Tabel</h2>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    Tambah
                </button>
            </div>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-warning btn-edit" data-bs-toggle="modal" data-bs-target="#editCategoryModal" data-kategori="{{ $category }}">Edit</button>
                        <button type="button" class="btn btn-outline-danger btn-delete" data-kategori-id="{{ $category->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tambah Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Tambah Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('category.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" action="{{ route('category.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id-kategori">
                            <label for="categoryName" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="categoryName" name="nama" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Category Form--}}
    <form id="deleteCategoryForm" action="{{ route('category.delete') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" id="deleteCategoryId">
    </form>
    {{-- {{ Form::open(["method" => "DELETE", "action" => ["category.delete", request("category_id")], "id" => "delete-category-form"]) }}
    {{ Form::hidden("id", null, ["id" => "publication-delete-id"]) }}
    {{ Form::close() }} --}}
@endsection

@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        $(".btn-delete").click(function() {
            let categoryId = $(this).data('kategori-id');
            $('#deleteCategoryId').val(categoryId);

            Swal.fire({
                title: "Yakin untuk menghapus kategori ini?",
                icon: "warning",
                cancelButtonText: "Batal",
                confirmButtonText: "Hapus",
                confirmButtonColor: "#d9534f",
                showCancelButton: true,
                allowOutsideClick: false,
                reverseButtons:true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteCategoryForm').submit();
                }
            });
        });
    </script>
    <script>
        $('.btn-edit').on('click', function() {
            let data = $(this).data('kategori');
            $('#id-kategori').val(data.id);
            $('#categoryName').val(data.name);
        });
    </script>
@endsection
