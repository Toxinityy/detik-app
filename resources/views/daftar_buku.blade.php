@extends('layouts.layout')

@section('title', 'Daftar Buku')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Kategori Tabel</h2>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
                    Tambah
                </button>
            </div>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Cover</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->description }}</td>
                    <td>
                        <img src="{{$book->cover_path}}" style="max-height: 5em;" alt="{{ $book->title }} Cover">
                        {{-- <p>{{ $book->cover_path }}</p> --}}
                    </td>
                    <td>
                        <a href="{{ $book->file_path}}" download="{{ $book->title }}.pdf">{{ $book->title }} PDF</a>
                    </td>
                    <td>
                        <button type="button" class="btn btn-outline-warning btn-edit" data-bs-toggle="modal" data-bs-target="#editBookModal" data-buku="{{ $book }}" data-buku-kat="{{ $bookCategories }}">Edit</button>
                        <button type="button" class="btn btn-outline-danger btn-delete" data-buku-id="{{ $book->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tambah Buku Modal -->
    <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBookTitle">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('book.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- untuk menyimpan user id --}}
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="cover" class="form-label">Upload Cover</label>
                            <input type="file" class="form-control" id="cover" name="cover" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="pdf" class="form-label">Upload PDF</label>
                            <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" required>
                        </div>

                        <div class="mb-3">
                            <label for="categories" class="form-label">Kategori</label>
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}">
                                    <label class="form-check-label">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookTitle">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBookForm" action="{{ route('book.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <input type="hidden" name="id" id="id-buku">
                            <input type="hidden" name="user_id" id="edit-id-user" value="{{ Auth::id() }}">

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="edit-description" name="description" required>
                        </div>
                        <div class="mb-3">
                            <label for="cover" class="form-label">Upload Cover</label>
                            <input type="file" class="form-control" id="edit-cover" name="cover" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload PDF</label>
                            <input type="file" class="form-control" id="edit-file" name="file" accept=".pdf" required>
                        </div>

                        <div class="mb-3">
                            {{-- <label for="categories" class="form-label">Kategori</label> --}}
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category{{ $category->id }}">
                                    <label class="form-check-label">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Category Form--}}
    <form id="deleteBookForm" action="{{ route('book.delete') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" id="deleteBookId">
    </form>
@endsection

@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        $(".btn-delete").click(function() {
            let bookId = $(this).data('buku-id');
            $('#deleteBookId').val(bookId);

            Swal.fire({
                title: "Yakin untuk menghapus buku ini?",
                icon: "warning",
                cancelButtonText: "Batal",
                confirmButtonText: "Hapus",
                confirmButtonColor: "#d9534f",
                showCancelButton: true,
                allowOutsideClick: false,
                reverseButtons:true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteBookForm').submit();
                }
            });
        });
    </script>
    <script>
        $('.btn-edit').on('click', function() {
            let data = $(this).data('buku');
            $('#id-buku').val(data.id);
            $('#edit-title').val(data.title);
            $('#edit-description').val(data.description);
            // $('#edit-cover').val(data.cover_path);
            // $('#edit-file').val(data.file_path);

            let selectedCategories = $(this).data('buku-kat');
            // console.log(selectedCategories);
            $('input[name="categories[]"]').each(function() {
                let categoryId = parseInt($(this).val());
                selectedCategories.forEach(function(selectedCategoryId) {
                    if(selectedCategoryId.id == data.id){
                        // console.log([selectedCategoryId.categories, categoryId]);
                        selectedCategoryId.categories.forEach(function(temp){
                            // console.log(temp);
                            if(temp.id === categoryId){
                                $(this).prop('checked', true);
                            }
                        })
                    }
                }.bind(this));
            });
        });
    </script>
@endsection

