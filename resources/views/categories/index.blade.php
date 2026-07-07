@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Kategori</h2>
    <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Kategori</a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Desktop Table View -->
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline form-delete">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <!-- Mobile Accordion View -->
        <div class="d-block d-md-none">
            <div class="accordion" id="accordionCategories">
                @forelse($categories as $category)
                <div class="accordion-item mb-2 border-0 shadow-sm rounded">
                    <h2 class="accordion-header" id="headingCat{{ $category->id }}">
                        <button class="accordion-button collapsed rounded bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCat{{ $category->id }}" aria-expanded="false" aria-controls="collapseCat{{ $category->id }}">
                            <div class="d-flex justify-content-between w-100 me-2">
                                <h6 class="mb-0 fw-bold">{{ $category->name }}</h6>
                                <small class="text-muted">ID: {{ $category->id }}</small>
                            </div>
                        </button>
                    </h2>
                    <div id="collapseCat{{ $category->id }}" class="accordion-collapse collapse" aria-labelledby="headingCat{{ $category->id }}" data-bs-parent="#accordionCategories">
                        <div class="accordion-body bg-white border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3">Belum ada kategori.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
