<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <div id="spinner"
            class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        @include('admin.include.sidebar')

        <div class="content">
            @include('admin.include.navbar')

            <div class="container-fluid pt-4 px-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="bg-white text-dark rounded p-4 shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h2 class="mb-0 text-primary">Brands</h2>
                                    <a href="{{ route('brands.create') }}" class="btn btn-primary">Add Brand</a>
                                </div>

                                <form method="GET" class="mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-4">
                                            <input type="text" name="q" class="form-control"
                                                placeholder="Search by name or slug" value="{{ $search }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-outline-primary" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th>Status</th>
                                                <th>Logo</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($brands as $brand)
                                                <tr>
                                                    <td>{{ $brand->name }}</td>
                                                    <td>{{ $brand->slug }}</td>
                                                    <td>{{ $brand->status ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        @if($brand->image)
                                                            <img src="/{{ $brand->image }}" alt="{{ $brand->name }}" width="60">
                                                        @else
                                                            <span class="text-muted">No image</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('brands.edit', $brand) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="{{ route('brands.destroy', $brand) }}" method="POST"
                                                            style="display:inline-block;"
                                                            onsubmit="return confirm('Delete this brand? This will unassign it from products.');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No brands found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{ $brands->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.include.footer')
            </div>
        </div>
</body>

</html>