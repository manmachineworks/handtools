<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')

<body>
    <div class="container-fluid position-relative d-flex p-0">
       
 @include('admin.include.sidebar')

        <!-- Content Start -->
        <div class="content">
            @include('admin.include.navbar')
            <!-- Recent Sales Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Page Meta Manager</h2>
                    <a href="{{ route('admin.metas.create') }}" class="btn btn-primary">+ Add New Meta</a>
                </div>
            
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

    @if($metas->isEmpty())
        <div class="alert alert-info">No meta data found. Click "Add New Meta" to create one.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Page Slug</th>
                        <th>Meta Title</th>
                        <th>Meta Keywords</th>
                        <th>Meta Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($metas as $index => $meta)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $meta->page_slug }}</strong></td>
                            <td>{{ Str::limit($meta->title, 50) }}</td>
                            <td>{{ Str::limit($meta->keyword, 50) }}</td>
                            <td>{{ Str::limit($meta->description, 50) }}</td>
                            <td>
                                <a href="{{ route('admin.metas.edit', $meta->id) }}" class="btn btn-sm btn-warning">Edit</a>

                                <form action="{{ route('admin.metas.destroy', $meta->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this meta entry?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
</div>
</div>
</body>
</html>
